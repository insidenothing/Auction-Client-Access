<?PHP
if ($_GET[pdf]){
system('rm -f *.jpg');
system('rm -f *.pdf');
$from = str_replace('http://hwestauctions.com/auctionInvoices/','/data/auction/invoices/',$_GET[pdf]);
system('cp '.$from.' page.pdf');
$error = system('gs -dNOPAUSE -q -r75 -sDEVICE=jpeg -dBATCH -sOutputFile=page%d.jpg page.pdf', $retval);
}
?>
<?PHP if (file_exists('page.jpg')){ ?>
<img src="page.jpg" style="position: relative" />
<?PHP 	$copy .= "<li>Rendered page.jpg</li>"; } ?>

<?PHP if (file_exists('page1.jpg')){ ?>
<img src="page1.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page1.jpg</li>"; } ?>

<?PHP if (file_exists('page2.jpg')){ ?>
<img src="page2.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page2.jpg</li>"; } ?>

<?PHP if (file_exists('page3.jpg')){ ?>
<img src="page3.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page3.jpg</li>"; } ?>

<?PHP if (file_exists('page4.jpg')){ ?>
<img src="page4.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page4.jpg</li>"; } ?>

<?PHP if (file_exists('page5.jpg')){ ?>
<img src="page5.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page5.jpg</li>"; } ?>

<?PHP if (file_exists('page6.jpg')){ ?>
<img src="page6.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page6.jpg</li>"; } ?>

<?PHP if (file_exists('page7.jpg')){ ?>
<img src="page7.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page7.jpg</li>"; } ?>

<?PHP if (file_exists('page8.jpg')){ ?>
<img src="page8.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page8.jpg</li>"; } ?>

<?PHP if (file_exists('page9.jpg')){ ?>
<img src="page9.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page9.jpg</li>"; } ?>

<?PHP if (file_exists('page10.jpg')){ ?>
<img src="page10.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page10.jpg</li>"; } ?>

<?PHP if (file_exists('page11.jpg')){ ?>
<img src="page11.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page11.jpg</li>"; } ?>

<?PHP if (file_exists('page12.jpg')){ ?>
<img src="page12.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page12.jpg</li>"; } ?>

<?PHP if (file_exists('page13.jpg')){ ?>
<img src="page13.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page13.jpg</li>"; } ?>

<?PHP if (file_exists('page14.jpg')){ ?>
<img src="page14.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page14.jpg</li>"; } ?>

<?PHP if (file_exists('page15.jpg')){ ?>
<img src="page15.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page15.jpg</li>"; } ?>

<?PHP if (file_exists('page16.jpg')){ ?>
<img src="page16.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page16.jpg</li>"; } ?>

<?PHP if (file_exists('page17.jpg')){ ?>
<img src="page17.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page17.jpg</li>"; } ?>

<?PHP if (file_exists('page18.jpg')){ ?>
<img src="page18.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page18.jpg</li>"; } ?>

<?PHP if (file_exists('page19.jpg')){ ?>
<img src="page19.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page19.jpg</li>"; } ?>

<?PHP if (file_exists('page20.jpg')){ ?>
<img src="page20.jpg" style="position: relative" />
<?PHP $copy .= "<li>Rendered page20.jpg, Should there be more pages??????</li>"; } ?>
