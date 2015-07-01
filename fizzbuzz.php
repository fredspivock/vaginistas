<?php 

for($i = 1; $i < 100; $i++)
{

	$fizzbuzz = '';
	
	$fizzbuzz .= ( ($i % 3) === 0) ? 'fizz': '';
	$fizzbuzz .= ( ($i % 5) === 0) ? 'buzz': '';

	if( $fizzbuzz ==='' )
	{
		echo($i);
	}
	else
	{
		echo($fizzbuzz);
	}
}
?>