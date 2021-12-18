<?php


    /*
	* Generate Rendom Number.
    *
    * @param integer $len
    * @param string $rand
    */
    function Rendom( $len = 9 ) {

		$rand   = '';

		while( !( isset( $rand[$len-1] ) ) ) {

			$rand   .= mt_rand( );

		}

		return substr( $rand , 0 , $len );

	}
    /*
    * Convert Bangla Numaric To English Numaric.
	* Convert English Numaric To Bangla Numaric.
    *
    * @param array $bn
    * @param array $en
    * @param string $number
    */
	/*
    * Converto Bangla Numaric To English Numaric.
    */

	function BnToEn($number) {

        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");

	    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        return str_replace($bn, $en, $number);

    }


	/*
    * Convert English Numaric To Bangla Numaric.
    */
    function EnToBn($number) {

        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");

	    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        return str_replace($en, $bn, $number);

    }


    /*
    * Convert English Date To Bangla Date.
    * @param number $date
    * @param string $month
    * @param number $year
    * @param number $hour
    * @param number $minute
    */

    function EnDateToBnDate($date, $month, $year, $hour, $minute){
        $date = EnToBn($date);
        $year = EnToBn($year);
        $hour = EnToBn($hour);
        $minute = EnToBn($minute);


        if($month == "January"){
            $bdMonth =  "জানুয়ারী";
        }
        if($month == "February"){
            $bdMonth =  "ফেব্রুয়ারী";
        }
        if($month == "March"){
            $bdMonth =  "মার্চ";
        }

        if($month == "April"){
            $bdMonth =  "এপ্রিল";
        }
        if($month == "May"){
            $bdMonth =  "মে";
        }
        if($month == "June"){
            $bdMonth =  "জুন";
        }
        if($month == "July"){
            $bdMonth =  "জুলাই";
        }
        if($month == "August"){
            $bdMonth =  "অগাস্ট";
        }
        if($month == "September"){
            $bdMonth =  "সেপ্টেম্বর";
        }
        if($month == "October"){
            $bdMonth =  "অক্টোবর";
        }
        if($month == "November"){
            $bdMonth =  "নভেম্বর";
        }
        if($month == "December"){
            $bdMonth =  "ডিসেম্বর";
        }

        // return $date+" "+$month+" "+$year+", "+$hour+":"+$minute;
        return "$date $bdMonth $year, $hour:$minute";

    }

    function EnDateToBnDateHeader($date, $month, $year){
        $date = EnToBn($date);
        $year = EnToBn($year);


        if($month == "January"){
            $bdMonth =  "জানুয়ারী";
        }
        if($month == "February"){
            $bdMonth =  "ফেব্রুয়ারী";
        }
        if($month == "March"){
            $bdMonth =  "মার্চ";
        }

        if($month == "April"){
            $bdMonth =  "এপ্রিল";
        }
        if($month == "May"){
            $bdMonth =  "মে";
        }
        if($month == "June"){
            $bdMonth =  "জুন";
        }
        if($month == "July"){
            $bdMonth =  "জুলাই";
        }
        if($month == "August"){
            $bdMonth =  "অগাস্ট";
        }
        if($month == "September"){
            $bdMonth =  "সেপ্টেম্বর";
        }
        if($month == "October"){
            $bdMonth =  "অক্টোবর";
        }
        if($month == "November"){
            $bdMonth =  "নভেম্বর";
        }
        if($month == "December"){
            $bdMonth =  "ডিসেম্বর";
        }

        return "$date $bdMonth $year";

    }

    /*
	* Number To Word Converter
    *
    * @param number as string / integre  $num
    * @param string $str
    * @param string $what
    * @param string $with
    * @param string $search
    * @param string $replace
    * @param array $words
    * @param array $list1
    * @param array $list2
    * @param array $list3
    * @param integer $num_length
    * @param integer $levels
    * @param integer $max_length
    * @param array $num_levels
    * @param integer $num_part
    * @param integer $hundreds
    * @param integer $tens
    * @param string $singles
    * @param integer $commas
    */
	function NumberToWord( $num = '' ){

		function trim_all( $str , $what = NULL , $with = ' ' ){
			if( $what === NULL )
			{
				//  Character      Decimal      Use
				//  "\0"            0           Null Character
				//  "\t"            9           Tab
				//  "\n"           10           New line
				//  "\x0B"         11           Vertical Tab
				//  "\r"           13           New Line in Mac
				//  " "            32           Space

				$what   = "\\x00-\\x20";    //all white-spaces and control chars
			}

			return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
		}

		function str_replace_last( $search , $replace , $str ) {
			if( ( $pos = strrpos( $str , $search ) ) !== false ) {
				$search_length  = strlen( $search );
				$str    = substr_replace( $str , $replace , $pos , $search_length );
			}
			return $str;
		}

		$num    = ( string ) ( ( int ) $num );

		if( ( int ) ( $num ) && ctype_digit( $num ) )
		{
			$words  = array( );

			$num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );

			$list1  = array('','one','two','three','four','five','six','seven',
				'eight','nine','ten','eleven','twelve','thirteen','fourteen',
				'fifteen','sixteen','seventeen','eighteen','nineteen');

			$list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
				'seventy','eighty','ninety','hundred');

			$list3  = array('','thousand','million','billion','trillion',
				'quadrillion','quintillion','sextillion','septillion',
				'octillion','nonillion','decillion','undecillion',
				'duodecillion','tredecillion','quattuordecillion',
				'quindecillion','sexdecillion','septendecillion',
				'octodecillion','novemdecillion','vigintillion');

			$num_length = strlen( $num );
			$levels = ( int ) ( ( $num_length + 2 ) / 3 );
			$max_length = $levels * 3;
			$num    = substr( '00'.$num , -$max_length );
			$num_levels = str_split( $num , 3 );

			foreach( $num_levels as $num_part )
			{
				$levels--;
				$hundreds   = ( int ) ( $num_part / 100 );
				$hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
				$tens       = ( int ) ( $num_part % 100 );
				$singles    = '';

				if( $tens < 20 )
				{
					$tens   = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
				}
				else
				{
					$tens   = ( int ) ( $tens / 10 );
					$tens   = ' ' . $list2[$tens] . ' ';
					$singles    = ( int ) ( $num_part % 10 );
					$singles    = ' ' . $list1[$singles] . ' ';
				}
				$words[]    = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
			}

			$commas = count( $words );

			if( $commas > 1 )
			{
				$commas = $commas - 1;
			}

			$words  = implode( ', ' , $words );

			//Some Finishing Touch
			//Replacing multiples of spaces with one space
			$words  = trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );
			if( $commas )
			{
				$words  = str_replace_last( ',' , ' and' , $words );
			}

			return $words;
		}
		else if( ! ( ( int ) $num ) )
		{
			return 'Zero';
		}
		return '';
	}



