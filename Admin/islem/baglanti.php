<?php






try {
	$baglanti= new PDO("mysql:host=localhost; dbname=eticaret",   'root', 'root'     );
	#echo "bağlantı başarılı";
} catch (Exception $e) {
	
	echo $e->getMessage();
}










/*


try {
	$baglanti= new PDO("mysql:host=localhost; dbname=ticaret",   'root', 'root'     );
	#echo "bağlantı başarılı";
} catch (Exception $e) {
	
	echo $e->getMessage();
}




*/

