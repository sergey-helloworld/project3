<?php 

foreach($curr as $row)
{
	echo "Код валюты: $row->ccy </br> Код национальной валюты: $row->base_ccy </br> Курс покупки: $row->buy </br> Курс продажи: $row->sale </br></br>";
}

?>