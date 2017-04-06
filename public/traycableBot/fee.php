 
<?php  


function fee_tray($data)
{

	$kind=substr($data,0,2);
	$type=substr($data,2,2);
	$width=substr($data,4,2);
	$thick=substr($data,6,2);

	$gheimat_vazn=38;
	$vazn=0;

	if ($kind==22) 
	{
		$gheimat_vazn=$gheimat_vazn+22;
	}


	switch ($width) 
	{
		case '40':
			$width=10;
		break;

		case '41':
			$width=15;
		break;

		case '42':
			$width=20;
		break;

		case '43':
			$width=30;
		break;

		case '44':
			$width=40;
		break;

		case '45':
			$width=50;
		break;		
	}

	switch ($thick) 
	{
		case '50':
			$vazn=16;
		break;

		case '51':
			$vazn=20;
		break;

		case '52':
			$vazn=24;
		break;

		case '53':
			$vazn=32;
		break;
	}

	$width=$width+10;

	$fee;
	$result;
	switch ($type) 
	{
		case '30':
			$fee=$vazn*$gheimat_vazn*$width;
			$result="قیمت هر متر: ". $fee/2 ." تومان\nقیمت هر شاخه: ".$fee." تومان";
		break;
		
		case '31':
			$width=$width-5;
			$fee=$vazn*$gheimat_vazn*$width;
			$result="قیمت هر متر: ". $fee/2 ." تومان\nقیمت هر شاخه: ".$fee." تومان";
		break;

		case '32':
			$fee=$vazn*$gheimat_vazn*$width;
			$fee=$fee/10;
			$result="قیمت هر عدد: ". $fee." تومان";
		break;

		case '33':
			$fee=$vazn*$gheimat_vazn*$width;
			$fee=$fee/2;
			$result="قیمت هر عدد: ". $fee." تومان";
		break;
	}
	return $result;
}

function fee_steelpipe($data)
{
	$text="";
	$kind=substr($data,0,2);
	$item=substr($data,2,2);
	$size=substr($data,4,2);

	if($kind==61)//sard o meshki
	{
		if($item==63)//looleh
		{
			$text="قیمت هر متر: ";
			if($size==66)			//13.5
			{
				$text=$text."1,970";	
			}
			elseif ($size==67)		//16
			{
				$text=$text."2,050"; 
			}
			elseif ($size==68)		//21
			{
				$text=$text."2,550";
			}
			elseif ($size==69)		//29
			{
				$text=$text."4,000";
			}
			elseif ($size==70)		//36
			{
				$text=$text."5,350";
			}
			elseif ($size==71)		//48
			{
				$text=$text."7,550";
			}
			$text=$text." تومان";
		}
		elseif ($item==64)//boshan
		{
			$text="قیمت هر عدد: ";
			if($size==66)			//13.5
			{
				$text=$text."180";	
			}
			elseif ($size==67)		//16
			{
				$text=$text."190"; 
			}
			elseif ($size==68)		//21
			{
				$text=$text."290";
			}
			elseif ($size==69)		//29
			{
				$text=$text."670";
			}
			elseif ($size==70)		//36
			{
				$text=$text."950";
			}
			elseif ($size==71)		//48
			{
				$text=$text."1350";
			}
			$text=$text." تومان";
		}
		elseif ($item==65)//bast spit
		{
			$text="قیمت هر عدد: ";
			if($size==66)			//13.5
			{
				$text=$text."1,100 ریال";	
			}
			elseif ($size==67)		//16
			{
				$text=$text."1,100 ریال"; 
			}
			elseif ($size==68)		//21
			{
				$text=$text."1,400 ریال";
			}
			elseif ($size==69)		//29
			{
				$text="لطفا تماس بگیرید";
			}
			elseif ($size==70)		//36
			{
				$text="لطفا تماس بگیرید";
			}
			elseif ($size==71)		//48
			{
				$text="لطفا تماس بگیرید";
			}
		}
	}
	elseif ($kind==62) //garm
	{
		if($item==63)//looleh
		{
			$text="قیمت هر متر: ";
			if($size==66)			//13.5
			{
				$text=$text."4,100";	
			}
			elseif ($size==67)		//16
			{
				$text=$text."4,200"; 
			}
			elseif ($size==68)		//21
			{
				$text=$text."5,500";
			}
			elseif ($size==69)		//29
			{
				$text=$text."6,600";
			}
			elseif ($size==70)		//36
			{
				$text=$text."7,600";
			}
			elseif ($size==71)		//48
			{
				$text=$text."12,600";
			}
			$text=$text." تومان";
		}
		elseif ($item==64)//boshan
		{
			$text="قیمت هر عدد: ";
			if($size==66)			//13.5
			{
				$text=$text."280";	
			}
			elseif ($size==67)		//16
			{
				$text=$text."290"; 
			}
			elseif ($size==68)		//21
			{
				$text=$text."490";
			}
			elseif ($size==69)		//29
			{
				$text=$text."850";
			}
			elseif ($size==70)		//36
			{
				$text=$text."1100";
			}
			elseif ($size==71)		//48
			{
				$text=$text."1800";
			}
			$text=$text." تومان";
		}
		elseif ($item==65)
		{
			$text="قیمت هر عدد: ";
			if($size==66)			//13.5
			{
				$text=$text."1,100 ریال";	
			}
			elseif ($size==67)		//16
			{
				$text=$text."1,100 ریال"; 
			}
			elseif ($size==68)		//21
			{
				$text=$text."1,400 ریال";
			}
			elseif ($size==69)		//29
			{
				$text="لطفا تماس بگیرید";
			}
			elseif ($size==70)		//36
			{
				$text="لطفا تماس بگیرید";
			}
			elseif ($size==71)		//48
			{
				$text="لطفا تماس بگیرید";
			}
		}
	}

	return $text;
}

function fee_flexi($data)
{
	
}



?>