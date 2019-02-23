<?php

foreach($history as $row)
{
	echo 'Дата: '.$row->ins_date.' Данные запроса: <a href="'.$base_url.$row->ins_date.'">Посмотреть</a></br>';
}

?>