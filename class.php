<?php

/**
* клас для обробки приемних данних GET
*/
class cURL
{
	public $method = 1; //по замовчуванюю метод GET
	public $form = 0; //по замовчуванню без надсилання форми
	public $urlServer = ''; //по замовчуванню змінна сервера пуста
	public $cookie = ''; //по замовчуванню змінна печеньок пуста
	public $formArray = array(); //массив для збирання iframe

	public function __construct()
	{
		$this->mathMethods($_REQUEST); //запускаємо обробку данних GET, які прийшли нам
		$this->cURLsend(); //запускаємо відправку данних по cURL
	}

	/**
		*  обробка данних які нам прийшли в адресному полі (GET)
	*/
	public function mathMethods($getArray) {
		foreach ($getArray as $key => $get) { //всі дані які нам прийшли розбераємо $key - ключ, $get - змінна
			switch ($key) {
				case 'method': //метод, якщо приходить g - це GET, якщо приходить p - це POST
					if($get == 'g')
						$this->method = 1; //GET
					else if($get == 'p')
						$this->method = 2; //POST
					break;

				case 'form':
					if($get == 'y') //чи є відправка форми, якщо приходить y - тоді будемо відправляти якісь дані на сервер
						$this->form = 1; //YES
					else 
						$this->form = 0; //NO
					break;

				case 'dest': //лінк на сервер до якого будемо звертатись
					$this->urlServer = $get;
					break;

				case 'cookie': //кукі які потрібно передати на інший сервер
					$this->cookie = $get;
					break;
				
				default:
					$formExplode = explode("formdata", $key); //все що має ключ "formdata" буде додано до форми, а після "formdata" додаємо назву ключа. А тоді вже змінну
					$this->formArray[$formExplode[1]] = $get; //додаємо до массиву змінних на відправку форми
					break;
			}
		}
	}

	/**
		*  функція для створення лінка відправки GET параметрів на сервер по cURL
	*/
	public function setUrlGet($method, $form, $formArray, $urlServer) { 
		if($method == 1 && $form == 1){ //якщо використання форми вказане і тип передачі даних GET, тоді
			$urlServer .= '?'; //додаємо до лінку знак запитання, щоб далі описати змінні
			foreach ($formArray as $key => $value) { //всі змінні, які у нас є в массиві розбираємо і перетворюємо в лінк
				$urlServer .= $key.'='.$value.'&'; //просте додавання змінних в лінк
			}
		}
		return $urlServer; //повертаємо лінк
	}

	public function cURLsend() {


		$curl = curl_init(); //ініціалізація cURL

		if($this->method == 1 && $this->form == 1) { //якщо використання форми вказане і тип передачі даних GET, тоді
			$this->urlServer = $this->setUrlGet($this->method, $this->form, $this->formArray, $this->urlServer); //викликаємо setUrlGet для обробки данних і повертаємо відповідь у змінну urlServer
		}
		else if($this->method == 2 && $this->form == 1) { //якщо використання форми вказане і тип передачі даних POST, тоді
			curl_setopt($curl, CURLOPT_POST, 1); //передача данних методом POST
			curl_setopt($curl, CURLOPT_POSTFIELDS, $this->formArray); //тут змінні, які будут передані методом POST
		}
		curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER["DOCUMENT_ROOT"]."/cookies1.txt"); //кукі із файлу
		curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER["DOCUMENT_ROOT"]."/cookies1.txt"); //записати всі кукі після закриття сесії у цей файл

		if($this->cookie != '') //якщо кукі передаємо у змінній cookie через GET на наш скрипт, тоді 
			curl_setopt($curl, CURLOPT_COOKIE, $this->cookie); //передаємо при допомозі cURL кукі із змінної

		curl_setopt($curl, CURLOPT_URL, $this->urlServer); //лінк сайту до якого звертаємось
		//curl_setopt($curl, CURLOPT_HEADER, 1); //виводимо заголовки
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //вернути відповідь, але без автоматичного відображення
		
		curl_setopt($curl, CURLOPT_USERAGENT, 'MSIE 5'); //це говорить "я не скрипт, я IE5"
		$res = curl_exec($curl); //завантаження сторінки у змінну $res
		//якщо отримали помилку, то друкуємо її на екран
		if(!$res) {
			$error = curl_error($curl).'('.curl_errno($curl).')';
			echo $error;
		} //якщо все добре, тоді виводимо відповідь на екран
		else
			echo $res; 
		curl_close($curl); //закриваємо сеанс
	}
}

/**
*  відображення данних (прийом)
*/
class readGetAndPost
{
	function __construct()
	{
		$this->readType();
	}

	public function readType() {
		if(isset($_COOKIE['my'])) //якщо нам прийшла печенька my, тоді виведемо її на екран 
			echo "cookie: ".$_COOKIE['my']."</br>"; 
		if (isset($_GET['name']) && isset($_GET['description'])) { //якщо є змінні GET (name, description), тоді вивести їх на екран
			echo "method: GET</br>";
			echo "name: ".$_GET['name']."</br>";
			echo "description: ".$_GET['description']."</br>";
		}
		else if(isset($_POST['name']) && isset($_POST['description'])){ //якщо є змінні POST (name, description), тоді вивести їх на екран
			echo "method: POST</br>";
			echo "name: ".$_POST['name']."</br>";
			echo "description: ".$_POST['description']."</br>";
		}
	}
}

?>