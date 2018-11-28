<?php

function extract_IdRequisiti($tipo){
	$conn=sql_conn();
	$query="SELECT r.CodAuto, r.IdRequisito
			FROM _MapRequisiti h JOIN Requisiti r ON h.CodAuto=r.CodAuto
			WHERE r.Tipo='$tipo'
			ORDER BY h.Position";
	$requi=mysqli_query($conn,$query) or fail("Query fallita: ".mysqli_error($conn));
	return $requi;
}

function fail($message){
	die($_SERVER['PHP_SELF'] . ": $message<br />");
}

function get_info($user){
	$conn=sql_conn();
	$user= mysqli_real_escape_string($conn,$user);
	$query="SELECT u.Password, u.Nome, u.Cognome
			FROM Utenti u
			WHERE u.Username= '".$user."' ";
	$query=mysqli_query($conn,$query) or fail("Query fallita: ".mysqli_error($conn));
	$db=mysqli_fetch_row($query);
	return $db;
}

function sql_conn(){
	$host="localhost";
	$user="root";
	$pwd="";
	$dbname="pragmadb";
	$conn=mysqli_connect($host,$user,$pwd)
			or fail("Connessione fallita!");
	mysqli_select_db($conn,$dbname);
	$query="SET @@session.max_sp_recursion_depth = 255";//necessario per garantire
	//max profondità possibile alle procedure ricorsive nei sistemi che non 
	//permettono di settare variabili globali
    $query=mysqli_query($conn,$query) or fail("Query fallita: ".mysqli_error($conn));
	return $conn;
}

?>