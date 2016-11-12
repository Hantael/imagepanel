#!/usr/bin/env php
<?php
// imagepanel.php for imagepanel in /home/hantael/rendu/PHP/imagepanel
//
// Made by MORARD Marine
// Login   <morard_m@etna-alternance.net>
//
// Started on  Fri Nov  4 15:16:55 2016 MORARD Marine
// Last update Sat Nov  5 11:37:09 2016 MORARD Marine
//

function	check_url($str)
{
  if (!(@$tmp = fopen($str, "r")))
    return (usage("can't open file/url"));
  if (!(fclose($tmp)))
    return (usage("can't close file/url"));
  if (!($file = file_get_contents($str)))
    return (usage("can't get content"));
  $re = '/<img[^>]+src="(http[^"]+.(?:GIF|gif|JPEG|jpeg|jpg|JPG|PNG|pgn';
  $re = $re . '))"[^>]*>/';
  if (!(preg_match_all($re, $file, $img)))
    return (usage("can't match img"));
  return ($img);
}

function	usage($str = "")
{
  if ($str != "")
    echo "error: ", $str, "\n";
  else
    {
      echo "\n\nphp imagepanel.php [options] lien1 [lien2 [...]] base\n\n";
      echo "OptionDescription\n-g La ou les images générées doivent être";
      echo " en GIF (.GIF ou .gif)\n-j La ou les images générées doivent";
      echo " être en JPEG (.JPEG, .jpeg, .JPG ou .jpg)\n-l L'argument suivant";
      echo " est le nombre maximum d'images incrustées dans la méta-image\n-n";
      echo " Afficher sous les images le nom de celles-ci (sans l'extension)\n";
      echo "-N Afficher sous les images le nom de celles-ci (avec l'extension)";
      echo "\n-p La ou les images générées doivent être en PNG (.PNG ou .png)";
      echo "\n-s Trier les images par ordre alphabétique\n\n\n";
      }
  return (0);
}

function	check_arg($argc, $argv)
{
  $i = 0;
  $flags_possible = "gjlnNps";
  $flags;
  $f = 0;
  $l = 0;
  $ar = 2;
  if (($argc < 3) || (!preg_match("/^-[g,j,l,n,N,p,s]+$/", $argv[1])))
    return (usage("arguments invalides"));
  while (isset($flags_possible[$i]))
    {
      $ch = $flags_possible[$i++];
      $re = '/[.*^-][^\' \']*(' . $ch . ')[^\' \']*/';
      if (preg_match($re, $argv[1]) == 1)
	{
	  $flags[$f++] = $ch;
	  if (strcmp($ch, "l") == 0)
	    {
	      if ($argc < 4)
		return (usage("arguments invalides"));
	      $ar = 3;
	      $l = $argv[2];
	    }
	}
    }
  if (!($img = check_url($argv[$ar])))
    return (usage());
  return ($img);
}

function	new_image($img)
{
$i = 0;
while (isset($img[1][$i]))
  echo $img[1][$i++], "\n";
$image = imagecreatetruecolor(800, 600);
imagejpeg($image, "image.jpg");
}

usage();
if (($img = check_arg($argc, $argv)) == 0)
  return ;
new_image($img);
?>