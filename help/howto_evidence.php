<?php

include("../code/includes.php");

$username = $_REQUEST['username'];

$display_user = new User();
$display_user->populateFromAttribute($username, "username");

?>

<html>
<head>
	<title>ACH: Help</title>
	<?php include("../parts/includes.php"); ?>
	<script language="JavaScript" type="text/javascript">

function changeFontSize(inc)

{

  var p = document.getElementsByTagName('p');

  for(n=0; n<p.length; n++) {

    if(p[n].style.fontSize) {

       var size = parseInt(p[n].style.fontSize.replace("px", ""));

    } else {

       var size = 14;

    }

    p[n].style.fontSize = size+inc + 'px';

   }

}

</script>
</head>

<?php include("../parts/header.php"); ?>







<?php
	
if( $active_user->logged_in ) { ?>
	


<?php include("../parts/menu_sidebar.php"); ?>

<?php } else { ?>



<?php include("../parts/login_sidebar.php"); ?>





</div>

<?php } ?>



<div class="mainContainer">

<div class="ydsf left"><div class="inner">



<div class="help">

<div class="fontSize"><a href="javascript:changeFontSize(1)" style:font-size="14px">Enlarge font</a><br /><a href="javascript:changeFontSize(-1)" style:font-size="8px">Shrink font</a></p></div>

<h2>Entering and Editing Evidence and Arguments</h2> 

<p>To enter evidence, click on the Enter Evidence/Arguments link beneath the project header on any page. On the next page, you'll be given two options: Single and Multiple. By default, you are given the single item entry form. Details on some of the different evidence information fields--Notes, Type, Date/Time, and Code--are below.</p>
<a name="multiple"</a>
<p>The Multiple option lets you add evidence in bulk. Many analysts store evidence in a spreadsheet. ACH's Multiple Evidence Entry tool lets you quickly add many evidence items if you've been storing them in this manner. However, entering your evidence like this will only allow you to insert two pieces of information per item: Evidence Name (a short description) and Evidence Notes (a more detailed description). Other information like Date/Time and Type will have to be inserted manually at a later time (see <strong>Editing Evidence</strong> below). To import multiple items from a spreadsheet, follow these steps:
<ul><li>Review your evidence spreadsheet and insure that you are using two columns: one to name the evidence, and another to describe it.</li>
<li>Copy your evidence. Using your mouse, click and drag across your evidence items so that both columns and all rows are highlighted. Then, from the Edit menu, choose Copy.</li>
<li>Paste the contents into the box on the Multiple Evidence Entry page, and click Save.</li>
</ul></p>

<a name="notes"</a>
 <h2>Evidence Notes</h2>

<p>The Evidence Notes section of the Enter Evidence/Arguments page is for entering information beyond what can be put in the matrix. The Notes may include a fuller description of the evidence, a reference to the source of the evidence, a hyperlink directly to the source document, or extracts or a full copy of the report. You can reveal the Notes while viewing a matrix by moving your mouse over the evidence labels in the left-most column. The Notes are also displayed on each evidence item's dedicated page, which you can reach by clicking the evidence label links.</p>

<p>An item of evidence is not required to have a Note. In a collaborative project, the entire team of analysts has a single set of notes for each evidence item, Changing the Notes field will change it for every other member of the project.</p>

<a name="type"</a>
<h2>Enter Type of Evidence</h2>

<p>Type of evidence often refers to the type of source that provided the evidence, but any other analytically useful set of categories may be used. For intelligence analysis, common types of evidence include such categories as HUMINT, SIGINT, Imagery, Open Source, Assumption, Logical Deduction, and Absence of Evidence. In a criminal investigation, it may be appropriate to have categories such as Police Report, Eye Witness Account, Interview, and Forensic Evidence. A counterintelligence investigator might use the column to catalogue Motive, Opportunity, Means, and Character Assessment. Right now, only a limited number of evidence types are available in ACH. More will be available soon.</p>

<p>Type of evidence can be entered on the Evidence page when adding evidence, and later by editing the evidence item (see <strong>Editing Evidence</strong> below). Sorting and analyzing the evidence by type can provide clues to the reliability of sources and signal possible deception. If all types of sources are telling a consistent story, that is a good sign. If not, try to figure out why. Are some sources vulnerable to manipulation for the purpose of deceiving you?</p>

<p>To sort by type of evidence, click on the Sort Evidence button and then select the Type variable. This will sort the types of evidence alphabetically. Note that when sorting evidence, you can sub-sort it by another variable. For example, if you were to choose Type as your first sorting variable and Diagnosticity as your second, you would easily be able to identify the most diagnostic or discriminating items of HUMINT or Imagery.</p>

<p>When evidence is entered and then sorted by diagnosticity or any other characteristic, the hypotheses are reordered by Inconsistency Score or Weighted Inconsistency Score, with the most likely hypothesis to the left. To facilitate consistent entering of data, a click on the Enter Evidence/Arguments button returns both the evidence and the hypotheses to their original order.</p>

<a name="serial"</a>
<h2>Enter Serial Number</h2>

<p>If your evidence is derived from a source document with a unique serial number, or if it came from a Web page with a URL, enter that serial number or URL into the Serial Number field. This will help you keep an accurate record of your evidence. It will also help you find other analysts working on similar problems: if you click on an evidence item from the matrix, you'll be taken to that item's dedicated page. The serial number will be displayed on that page, and clicking the link next to it ("Who else is using this?") will show you all other ACH projects in your organization that are using that source document.</p>

<a name="datetime"</a>
<h2>Enter Date/Time</h2>
<p>The date or time when events occurred is significant for some analyses, especially counterintelligence or criminal investigations. You can enter the date and time of events on the Enter Evidence/Arguments page, under the Date/Time field. (You can always change this later using Edit Evidence.)</p>

<p>When viewing the matrix, this information is hidden by default in order to simplify the presentation and make more room to list hypotheses. To show the Date/Time column, click the Show Data Columns link and check the Date/Time box. You can sort by Date/Time by clicking on the column header, or by using the Sort Evidence tools. Doing so will turn your matrix into a chronological list of events.</p>

<p>In order for the evidence to sort correctly, you must use the following format:<br />
<em>YYYY-MM-DD HH:MM:SS</em><br />
Both date and time are optional. However, if you choose to enter a time, you must also enter a date.</p>

<a name="code"</a>
<h2>Enter Code</h2>

<p>The Code function is an extra, free-entry text field that gives the analyst the flexibility to enter any additional set of categories the analyst might wish to use to sort the evidence; it is similar to "tags" on many popular Web sites. For example, you might want to code the data by country or by state. You can also use this column to track a specific stream of HUMINT reporting, or to identify reporting from a specific news organization like the BBC. The Code function can also be used to flag specific reports that you suspect might constitute denial, deception, or inaccurate reporting. The Code column sorts alphabetically or numerically.</p>

<p>The default view of the matrix hides the Code column. To show this column, click the Show Data Columns link and check the Code box. To sort by Code, click the Code column's header, or use the Sort Evidence tools.</p>

<h2>Editing Evidence</h2>
 
<p>All of the above attributes can be changed. To edit evidence, click on the evidence label in any matrix; each evidence label in a matrix is hyperlinked to a dedicated page about that piece of evidence. On that page, click the Edit Evidence Information link. Make the appropriate changes and click the Save Changes button.</p>

<p>Only the project owner may delete evidence. If you are the project owner, you'll notice a red Delete Evidence Record link next to the Edit link. Upon clicking this link, you'll be asked to verify the deletion.</p>

<h2>Finding Evidence</h2>

<p>Because the order of evidence is changed whenever it is sorted, it may become hard to find a particular piece of evidence in the matrix. The easiest way to find it is with your Web browser's Find command, under the Edit menu in Internet Explorer and Firefox.</p>

<p>ACH also automatically numbers each item of evidence as it is entered. This reflects the order in which evidence was entered, and this numbering cannot be changed. This number is hidden by default. To reveal it, choose Order Added from the Show Data Columns menu. You can sort and reverse sort the evidence by clicking the Order Added column header. For other sorting methods, see the Sort Evidence section.</p>


</div>










</div></div>

</div>







</div>

</div></div>

</div>







<?php include("../parts/footer.php"); ?>





</body>
</html>