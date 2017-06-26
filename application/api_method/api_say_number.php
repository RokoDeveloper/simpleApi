<?php

class Api_Say_Number extends Api
{

	function num_format($number)
	{
		$result = array();
		$to_nineteen = array(
		 '',
		 'one',
		 'two',
		 'three',
		 'four',
		 'five',
		 'six',
		 'seven',
		 'eight',
		 'nine',
		 'ten',
		 'eleven',
		 'twelve',
		 'thirteen',
		 'fourteen',
		 'fifteen',
		 'sixteen',
		 'seventeen',
		 'eighteen',
		 'nineteen'
		);

		$to_hundred = array(
		 '',
		 'ten',
		 'twenty',
		 'thirty',
		 'forty',
		 'fifty',
		 'sixty',
		 'seventy',
		 'eighty',
		 'ninety',
		 'hundred');

		$millions = array('',
		 'thousand',
		 'million',
		 'billion',
		 'trillion',
		 'quadrillion',
		 'quintillion',
		 'sextillion',
		 'septillion',
		 'octillion',
		 'nonillion',
		 'decillion',
		 'undecillion'
		);
		$number_length = strlen($number);
		$degrees = (int) (($number_length + 2) / 3);
		$max_length = $degrees * 3;

		$number = substr('00' . $number, -$max_length);
		$number_degrees = str_split($number, 3);

		for ($i = 0; $i < count($number_degrees); $i++) {
				$degrees -= 1;
				$hundreds = (int) ($number_degrees[$i] / 100);
				$hundreds = ($hundreds ? ' ' . $to_nineteen[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '');
				$tens = (int) ($number_degrees[$i] % 100);
				$singles = '';
				if ( $tens < 20 ) {
						$tens = ($tens ? ' ' . $to_nineteen[$tens] . ' ' : '' );
				} else {
						$tens = (int)($tens / 10);
						$tens = ' ' . $to_hundred[$tens] . ' ';
						$singles = (int) ($number_degrees[$i] % 10);
						$singles = ' ' . $to_nineteen[$singles] . ' ';
				}
				$result[] = $hundreds . $tens . $singles . ( ( $degrees && ( int ) ( $number_degrees[$i] ) ) ? ' ' . $millions[$degrees] . ' ' : '' );
		}


		$words = implode(' ', $result);
		$this->print_message($words);
	}

	function action_index()
	{

    if(!empty($_FILES))
    {
      foreach($_FILES as $key => $value)
      {
        $number = (int) file_get_contents($value['tmp_name']);

        if(is_int($number))
        {

					$this->num_format($number);

        }

      }
    }
	}
}
