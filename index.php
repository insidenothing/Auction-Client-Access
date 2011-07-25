<?PHP
include 'header.php';
?>

<div style="font-size:20px; padding:5px;">
  Welcome <?PHP echo $user[name]?>,<br /><br />
</div>
<br />


<?PHP
include 'footer.php';
?>
<script>

function detectPopupBlocker() {
  var myTest = window.open("about:blank","","directories=no,height=1,width=1,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");
  if (!myTest) {
    alert("A popup blocker was detected. Please Allow http://portal.hwestauctions.com");
  } else {
    myTest.close();
    //alert("No popup blocker was detected.");
  }
}
window.onload = detectPopupBlocker;
</script>
