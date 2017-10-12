<?php

if(isset($_COOKIE['my'])) //якщо нам прийшла печенька my, тоді виведемо її на екран 
	echo "cookie: ".$_COOKIE['my']."</br>"; 
if (isset($_GET['first'])) { //якщо є змінні GET (name, description), тоді вивести їх на екран
	echo "method: GET</br>";
	echo "first: ".$_GET['first']."</br>";
	echo "last: ".$_GET['last']."</br>";
	echo "birthday: ".$_GET['birthday']."</br>";
	echo "gender: ".$_GET['gender']."</br>";
	echo "age: ".$_GET['age']."</br>";
	echo "phone: ".$_GET['phone']."</br>";
}
else if(isset($_POST['first'])){ //якщо є змінні POST (name, description), тоді вивести їх на екран
	echo "method: POST</br>";
	echo "first: ".$_POST['first']."</br>";
	echo "last: ".$_POST['last']."</br>";
	echo "birthday: ".$_POST['birthday']."</br>";
	echo "gender: ".$_POST['gender']."</br>";
	echo "age: ".$_POST['age']."</br>";
	echo "phone: ".$_POST['phone']."</br>";
}
?>