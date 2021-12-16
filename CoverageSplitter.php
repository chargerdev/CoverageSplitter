<?php
/* ChargerDev */


/******* Code to grab critical and non critical code from css files. *******/

// File of which you want crucial and non crucial css.
$targetCssFile = 'Name of the file';

// Name of output file.
$crucialOutput = 'crucial.css';
$nonCrucialOutput = 'nonCrucial.css';

// Add the location of the coverage file.
$coverageFile = file_get_contents('Add location of coverage file');

$CF = json_decode($coverageFile, true);

if(empty($CF)){
	echo 'File is empty! Kindly check the file and try again.';
	return;
}

$crucialCSS = '';
$nonCrucialCSS = '';

foreach( $CF as $arr ) {
    if( strpos( $arr['url'], $targetCssFile ) ) {
        foreach ($arr['ranges'] as $name => $value) {
            $length = $value['end'] - $value['start'];
            $crucialCSS .= substr($arr['text'], $value['start'], $length) . PHP_EOL;
        }
		
		$temp=0;
		$length=0;
		
        foreach ($arr['ranges'] as $name => $value) {
            $length = $value['start'] - $temp;
            $nonCrucialCSS .= substr($arr['text'], $temp, $length) . PHP_EOL;
			$temp = $value['end'];
        }
        $nonCrucialCSS .= substr($arr['text'], $temp, $length) . PHP_EOL;
        
        break;
    }
}

echo $crucialCSS;
echo '<br><br><br>';
echo $nonCrucialCSS;
file_put_contents($crucialOutput, $crucialCSS);
file_put_contents($nonCrucialOutput, $nonCrucialCSS);
?>
