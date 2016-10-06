<?php

function vardump($var)
{
	echo "<pre>";
	if(isset($var))
	{
		var_dump($var);
	}
	else
	{
		echo 'NULL';
	}
	echo "</pre>";
}

if(!function_exists('refresh'))
{
	function refresh()
	{
		redirect($_SERVER['HTTP_REFERER']);
	}
}

function format_date($date)
{
    $mesi = array(1=>'gennaio', 'febbraio', 'marzo', 'aprile',
                'maggio', 'giugno', 'luglio', 'agosto',
                'settembre', 'ottobre', 'novembre','dicembre');

$giorni = array('domenica','lunedì','marted','mercoledì',
                'giovedì','venerdì','sabato');

list($sett,$giorno,$mese,$anno) = explode('-',date('w-d-n-Y', strtotime($date)));

return ucfirst($giorni[$sett]).' '.$giorno.' '.ucfirst($mesi[$mese]).' '.$anno;
    
}

function floatize($str)
{
	return (float) str_replace(',', '.', $str);
}

function big_float_format($float)
{
	if ($float / 1000000 > 1)
	{
		return number_format(round($float / 1000000,1), 1, ',', '.') . 'M';
	}
	elseif ($float / 1000 > 1)
	{
		return number_format(round($float / 1000,1), 1, ',', '.') . 'K';
	}
	else
	{
		return number_format($float, 2, ',', '.');
	}
}

function sh_date_format($date)
{
	$now	= time();
	$gap	= $now - strtotime($date);
	
	$cycle		= array('d', 'm', 'Y');
	$current	= array();
	$to_check	= array();
		
	if($gap < (61))
	{
		return $gap . ' secondi fa';
	}
	
	// date after 1 hour ago
	if($gap < (3600))
	{
		return ceil($gap / 60) . ' minuti fa';
	}
	
	// date after 6 hours ago
	if($gap < (3600 * 6))
	{
		return ceil($gap / 3600) . ' ore fa';
	}
	
	
	$is_today = TRUE;
	
	foreach($cycle as $format)
	{
		$current[$format]	= date($format, time());
		$to_check[$format]		= date($format, strtotime($date));
		
		if($current[$format] != $to_check[$format])
		{
			$is_today = FALSE;
		}
	}
	
	if($is_today)
	{
		return 'Oggi alle ' . date('H:i', strtotime($date));
	}
	
	if ( ! $is_today)
	{
		if(($current['d']-1) == $to_check['d'] AND $current['m'] == $to_check['m'] AND $current['Y'] == $to_check['Y']) 
		{
			return 'Ieri alle ' . date('H:i', strtotime($date));
		}
	}
			
	return date('d/m/Y - H:i', strtotime($date));
}

function dropize_me($list, $label = 'name', $key = 'id')
{
	$return = array();
	
	foreach($list as $item)
	{
		$return[$item->$key] = $item->$label;
	}
	
	return $return;
}


function loop_categories($list)
{
	$return = '';
	foreach($list as $item)
	{
		$active = ($item->get_route() == base_url(uri_string())) ? ' active' : '';
		$icon	= ($item->is_branch()) ? 'plus' : 'chevron-right';
		
		if(/*$_GET['qwe'] AND */$item->front_hex AND $item->back_hex)
		{
			
			$return .= '
					<a href="' . $item->get_route() . '" class="list-group-item' . $active . ' category_' . $item->id . '">
						<i class="fa fa-'. $icon .'"></i>
						' . $item->get_content('name') . '
					</a>

					'/*
					<style>
						.category_' . $item->id . ' { background-color: #' . $item->back_hex . ' !important; color: #' . $item->front_hex . ' !important; border-color:#' . $item->back_hex . ' !important }
						.category_' . $item->id . ':hover { background-color: #f3f3f3 !important}
						.active.category_' . $item->id . ':hover { background-color: #' . $item->back_hex . ' !important}
						.category_' . $item->id . ' .fa { color: #' . $item->front_hex . ' !important; }
						.active.category_' . $item->id . ' .fa { color: #555 !important; }
						.active.category_' . $item->id . ' { border-left:3px solid #' . $item->front_hex . ' !important; margin-left:-2px }
					</style>
					-->
					*/ . '
					<style>
						.category_' . $item->id . ' { border-color: #' . $item->back_hex . ' !important; color: #' . $item->front_hex . ' !important; border-color:#' . $item->back_hex . ' !important }
						.category_' . $item->id . ':hover { background-color: #' . $item->back_hex . ' !important}
						.active.category_' . $item->id . ',
						.active.category_' . $item->id . ':hover { background-color: #' . $item->back_hex . ' !important}
						.category_' . $item->id . ' > .fa { color: #' . $item->front_hex . ' !important; }
						.active.category_' . $item->id . ' .fa { color: #555 !important; }
						.active.category_' . $item->id . ' { border-left:3px solid #' . $item->front_hex . ' !important; margin-left:-2px }
						.category_' . $item->id . '.list-group-item-childs { border-color: #' . $item->back_hex . ' !important}
					</style>
			';
			
		}
		else
		{
			$return .= '
					<a href="' . $item->get_route() . '" class="list-group-item'. $active .'">
						<i class="fa fa-'. $icon .'"></i>
						' . $item->get_content('name') . '
					</a>
			';
		}
		
		
		if($item->is_branch())
		{
			$return .= '
					<div class="list-group-item-childs category_' . $item->id .'">
						'. loop_categories($item->get_childs()) .'
					</div>
			';
		}
	}
	
	return $return;
}


class SomeHelper
{
	 /**
	 * Generate random float number.
	 *
	 * @param float|int $min
	 * @param float|int $max
	 * @return float
	 */
	public static function rand($min = 0, $max = 1)
	{
		return ($min + ($max - $min) * (mt_rand() / mt_getrandmax()));
	}
	
	/**
	 * Calculate distance between 2 GPS points
	 * 
	 * @param type $lat1
	 * @param type $lon1
	 * @param type $lat2
	 * @param type $lon2
	 * @param type $unit (K / N)
	 * @return type
	 */
	public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ceil($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}

}

?>