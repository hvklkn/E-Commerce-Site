<?php 
session_start();
require_once 'Admin/islem/baglanti.php';

if (isset($_POST['login'])) {

	$kadi=htmlspecialchars($_POST['kadi']);
	$sifre=htmlspecialchars($_POST['sifre']);
	$sifreguclu=md5($sifre);



	$kullanicisor=$baglanti->prepare("SELECT * from kullanici where kullanici_adi=:kullanici_adi and kullanici_sifre=:kullanici_sifre and kullanici_yetki=:kullanici_yetki");
	$kullanicisor->execute(array(
		'kullanici_adi'=>$kadi,
		'kullanici_sifre'=>$sifreguclu,
		'kullanici_yetki'=>1


	));


	$var=$kullanicisor->rowCount();
 
	if ($var >0) {
		$_SESSION['normalgiris']=$kadi;
		Header("Location:index?durum=hosgeldin");
	}
	else{
		Header("Location: giris?durum=hata");
	}

}





if (isset($_POST['register'])) {
	

$kadi=htmlspecialchars($_POST['kadi']);
$sifre=htmlspecialchars($_POST['sifre']);
$sifrem=md5($sifrem);
$sifreiki=htmlspecialchars($_POST['sifretekrar']);
$mail=htmlspecialchars($_POST['email']);
$adsoyad=htmlspecialchars($_POST['adsoyad']);


$kullanicisor=$baglanti->prepare("SELECT * from kullanici where kullanici_adi=:kullanici_adi and kullanici_yetki=:kullanici_yetki ");
	$kullanicisor->execute(array(
		'kullanici_adi'=>$kadi,
		'kullanici_yetki'=>1
# admin kullanıcıları dahil değil 

	));


	$var=$kullanicisor->rowCount();
#kullanıcı varmı yokmu

if ($var > 0) {
	#varsa burası
	Header("Location:giris?durum=kullanicivar");
}
else{
	if ($sifre==$sifreiki) { 
		#şifreler birbirine eşitmi?

	if (strlen($sifre)>=8) {
#eğer 8den büyükse işlem yap


$kullanicikaydet=$baglanti->prepare("INSERT into kullanici SET 



			kullanici_adi=:kullanici_adi,
			kullanici_sifre=:kullanici_sifre,
			kullanici_adsoyad=:kullanici_adsoyad,
			kullanici_yetki=:kullanici_yetki,
			kullanici_mail=:kullanici_mail
			

			");

		$insert=$kullanicikaydet->execute(array(
			'kullanici_adi'=>$kadi,
			'kullanici_sifre'=>$sifrem,
			'kullanici_adsoyad'=>$adsoyad,
			'kullanici_yetki'=>1,
			'kullanici_mail'=>$mail



		));
		if ($insert) {

			header("Location:kullanici?durum=basarili");
		}
		else{
			header("Location:giris?durum=basarisiz");
		}







	}
	else{
	Header("Location:giris?durum=sifreeksik");
	}
	}
	else{
	Header("Location:giris?durum=sifrehata");
	}
}

}
 










if (isset($_POST['sepeteekle'])) {

$id=$_POST['urunid'];
$adet=$_POST['adet'];


setcookie('sepet['.$id.']', $adet, strtotime("+7day"));

Header("Location:sepet?durum=eklendi");
}







if (isset($_GET['sepetsil'])) {

$id=$_GET['id'];
$adet=$_GET['adet'];


setcookie('sepet['.$id.']', $adet, strtotime("-7day"));

Header("Location:sepet?durum=silindi");
}





?>