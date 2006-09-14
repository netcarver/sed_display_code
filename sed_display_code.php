<?php

$plugin['name'] = 'sed_display_code';
$plugin['version'] = '0.6';
$plugin['author'] = 'Stephen Dickinson';
$plugin['author_uri'] = 'http://txp-plugins.netcarving.com';
$plugin['description'] = 'Allows presentation of a code listing (from a file) in your articles.';

$plugin['type'] = 0; // 0 = regular plugin; public only, 1 = admin plugin; public + admin, 2 = library

@include_once('../zem_tpl.php');

if (0) {
?>
<!-- CSS
# --- BEGIN PLUGIN CSS ---
<style type="text/css">
div#sed_help td { vertical-align:top; }
div#sed_help code { font-weight:bold; font: 105%/130% "Courier New", courier, monospace; background-color: #FFFFCC;}
div#sed_help code.sed_code_tag { font-weight:normal; border:1px dotted #999; background-color: #f0e68c; display:block; margin:10px 10px 20px; padding:10px; }
div#sed_help a:link, div#sed_help a:visited { color: blue; text-decoration: none; border-bottom: 1px solid blue; padding-bottom:1px;}
div#sed_help a:hover, div#sed_help a:active { color: blue; text-decoration: none; border-bottom: 2px solid blue; padding-bottom:1px;}
div#sed_help h1 { color: #369; font: 20px Georgia, sans-serif; margin: 0; text-align: center; }
div#sed_help h2 { border-bottom: 1px solid black; padding:10px 0 0; color: #369; font: 17px Georgia, sans-serif; }
div#sed_help h3 { color: #693; font: bold 12px Arial, sans-serif; letter-spacing: 1px; margin: 10px 0 0;text-transform: uppercase;}
</style>
# --- END PLUGIN CSS ---
-->
<!-- HELP
# --- BEGIN PLUGIN HELP ---
<div id="sed_help">

h1(#manual). Display Code Plugin

sed_display_code plugin, v0.6 (June 15th, 2006)

Takes a file--with a *.txt* extension--and formats it for output as a line-numbered list.
Highlights can be applied to entire lines.
However, no attempt is made at source code formatting of keywords of any kind, not even the recognition of comments.

v0.6 Additional features&#8230;

* Implemented a new option to have the listing structured as an ordered list.
** If your listing starts from line 1 of your source file then this will validate in strict mode.
** If your listing starts from any other line then, unfortunately, it will only validate in a transitional doctype.

h2(#procedure). TXP Upload Procedure

# Create a category/categories for you code listing files.
# Prepare your listing files -- remember they need to have a .txt extension.
# Use the TXP Admin interface to upload your files.
# Put the @<txp:sed_display_code/>@ tag in your articles/forms as needed and customize it's attributes.
## You need to set the _dir_ attribute to the files directory of your TXP installation. By default: _dir='files'_.
## If you want a download link at the foot of the listing with the active download count then you need to add the *show_count* attribute. Set the value to the text you want to appear next to the count: *show_count='Copies Downloaded:'*

h2(#atts). Display Code Attributes.

The plugin can take the following attributes&#8230;

|_. Attribute    |_. Default Value |_. Status   |_. Description |
| 'file'       | None          | Needed   | Name of the file to process. |
| *'dir'*      | *'files'*     | *Optional* | Directory to use to look for file. *Note the change from the old default value of 'code'. If you were relying on this old default value, please add 'dir="code"' to your tag call. * |
| *'list_type'*  | *'table'*       | *Optional* | *Choose which underlying structure will be used for your code listing.* Valid values: 'table' or 'ol'. The default value is 'table' because it has better browser support and validates in more @doctypes@ than ordered lists with variable start/end lines. |
| 'list_text'  | 'Listing'     | Optional | Text used to tag the title of the listing. Set this to '' to omit the title. |
| 'list_no'    | ''            | Optional | Any non-empty value will be placed after the list_text variable in the title. | 
| 'class'      |'sed_dc_wrap'  | Optional | Class to use in marking up the wraptag. |
| 'wraptag'	   | 'div'         | Optional | Name of the tag to use to wrap the listing. |
| 'link_text'  | 'Download this code.' | Optional | Text to use when printing the download option (set to '' to disable download.) |
| 'link_title' | 'Downloads the above listing as a text file.' | Optional | Text used to title the download link (if enabled.) |
| *'show_count'* | *''*        | *Optional* | *Omit or leave blank to prevent the download count from being shown. Otherwise, supply the string that will prefix the download count.* |
| 'start'      | '1'           | Optional | The line of the text file to start the listing from. (Omit to start from the beginning.) | 
| 'end'        | ''            | Optional | The last line of the text file to display. (Omit to list to the end of the file.) |
| 'highlight1' | '-1'          | Optional | List of line numbers to tag with highlight class 1. (Omit to tag no lines). |
| 'highlight2' | '-1'          | Optional | List of line numbers to tag with highlight class 1. (Omit to tag no lines). |
| 'highlight3' | '-1'          | Optional | List of line numbers to tag with highlight class 1. (Omit to tag no lines). |
| 'sum_text'   | 'This table lists the contents of the file' | Optional | The text used in the table's summary attribute. |
| 'listclass'  | 'sed_dc'      | Optional | Class used to mark up the table. |
| 'errorclass' | 'sed_dc_error' | Optional | Class used to mark up any error messages generated by the plugin. |
| 'err_text'   | 'was not found.' |Optional | Text used in the file not found message. (Goes after the filename). |
| -'showver'-    | -'0'-           | -Optional- | -Displays the name of the plugin and it's version and makes it a link to the plugin's homepage.- |

*Emphasized items* have been added or changed since the last release.
-Struck out items- have been removed since the last release.

h2. Examples&#8230;

h3. Basic use.

<code><txp:sed_display_code file='foo' /></code>
Looks for 'foo.txt' in the default code directory (\code) from the site root. If it exists, it will display a <code><div></code> with the default title line, the listing body and the default download link.
*NOTE:* If the file is called 'foo.txt', *don't* write file="foo.txt", *do* write file="foo".

If your file is called bar.c and is in 'c files' then simply prepare bar.c.txt (must have .txt at the end of the filename) in that directory and use: 
<code><txp:sed_display_code dir='c files' file='bar.c' /></code>

h3. Wrap tag and class.

By default the list will be output in a <code><div></code> with *class="sed_dc_wrap"*. However, you can change this using the wraptag and class attributes&#8230;
<code><txp:sed_display_code file='header.h' wraptag='p' class='my-class' /></code>

*NOTE:* Using the default <code><div></code> is recommended but changing the class could be useful, but _don't forget to include the appropriate styles in your style sheet!_

h3. Customising the title.

To turn off the title text line&#8230;
<code><txp:sed_display_code file='foo' list_text='' /></code>

To give the listing an identifier&#8230;
<code><txp:sed_display_code file='foo' list_no='x' /></code> where 'x' is a number--or whatever string you would like.

To give the listing a different label, like 'snippet 4'&#8230;
<code><txp:sed_display_code file='foo' list_text='snippet' list_no='4' /></code>

h3. Customising the download link.

To omit the download link totally&#8230;
<code><txp:sed_display_code file='foo' link_text='' /></code>

To change the link text and the pop-up label that goes with it&#8230;

<code><txp:sed_display_code file='foo' link_text='Grab the code!' link_title='Right click and save as&#8230;' /></code>

To use the Textpattern file manager, set the _dir_ attribute to match your Textpattern install's files directory. By default this is 'files'.

Upload your .txt files through the admin interface.

<code><notextile><txp:sed_display_code file='snip.php' dir='files' link_text='Grab the code'/></notextile></code>

This will produce a download link via the TXP file handling functions so that the download count will be recorded. If you want to see the current download count as part of the download link then you will need to supply the new *show_count* attribute and set it to the string you want to describe the count. Like this:-

<code><notextile><txp:sed_display_code file='snip.php' dir='files' link_text='Grab the code' show_count='Downloads:'/></notextile></code>

h3. Displaying a 'chunk' of a file.

To display line 20 onwards from file foo.txt use&#8230;
<code><txp:sed_display_code file='foo' start='20' /></code>

To display from the start of bar.txt to line 30 use&#8230;
<code><txp:sed_display_code file='bar' end='30' /></code>

To display lines 23 to 32 of file accounts.php.txt use&#8230;
<code><txp:sed_display_code file='accounts.php' start='23' end='32' /></code>

h3. Playing with highlights.

To list file baz.c.txt and to highlight lines 25, 30 and 32 with style 'hi1' use&#8230;
<code><txp:sed_display_code file='baz.c' highlight1='25,30,32' /></code>

If you wanted to highlight with styles 'hi2' and 'hi3'as well then add&#8230;
<code><txp:sed_display_code file='baz.c' highlight1='25,30,32' highlight2='5,10' highlight3='31'/></code>

*NOTE:* Simply use a comma seperated list of numbers in the highlight1/2/3 attributes to tag those rows as needed. Which highlight takes precedence will depend upon the order of the style rules in your style sheet.

h2. Example CSS markup.

Here is an example of usable CSS for this plugin.
<code>
div.sed_dc_wrap {
	font:1em/1.4em "Courier New", courier, monospace;
	color:#333;
	border:0 solid #999;
	border-width:1px 0 0;
	padding:0.5em 0;
	margin:2em 0.5em 0.5em;
	overflow: hidden;
}
table.sed_dc {
	border-collapse:collapse; 
	width:99%;
}
table.sed_dc caption, p.sed_dc {
	text-align: center;
	font: bold 12px Arial, sans-serif;
	letter-spacing: 1px;
	color: #693;
}
table.sed_dc caption {
	text-align: left;
	border:0;
	margin:0;
	text-transform: uppercase;
}
p.sed_dc {
	margin-top:5px;
	font-variant: small-caps;
}
table.sed_dc tr {
	vertical-align:top; 
	background: white none; 
	overflow: hidden;
}
table.sed_dc tr.odd { background: #e6e6fa none; }
table.sed_dc tr.hi1, .hi1 { background-color: #006400; color: white; font-weight: bold; }
table.sed_dc tr.hi2, .hi2 { background-color: yellow;  color: black; font-weight: bold; }
table.sed_dc tr.hi3, .hi3 { background-color: #add8e6; color: black; font-weight: bold; }
table.sed_dc col.line-no	{ border-right:1px solid #999; }
table.sed_dc th { font-weight: bold; text-align: center; }
table.sed_dc td { padding:0 0.5em; }
table.sed_dc td.tab0 { padding-left:1.5em; }
table.sed_dc td.tab1 { padding-left:3em; }
table.sed_dc td.tab2 { padding-left:4.5em; }
table.sed_dc td.tab3 { padding-left:6em; }
table.sed_dc td.tab4 { padding-left:7.5em; }
table.sed_dc td.tab5 { padding-left:9em; }
table.sed_dc td.tab6 { padding-left:10.5em; }
p.sed_dc_error {
	border: 1px dotted red;
	background-color: #FFCCCC;
	margin: 5px;
	padding: 5px;
}
table.sed_dc tr:hover td { background: #483d8b; color: white; font-weight: bold; }
</code>

*NOTE* The last line allows some browsers to highlight the line you are pointing at with the mouse.

h2. Version History.

v0.6 May 15th, 2006.

* I re-worked the code to implement either tabular or ordered list output.

v0.5 June 5th, 2006.

* Integrated support for uploads via the TXP admin interface.
* Added download counter via a new attribute
* Removed the show_ver attribute.

v0.4 April 23rd, 2006.

* Simplified the table markup.
* Added the summary attribute to the table declaration.
* Added new tag attributes to control classes and allow internationalisation of output text.

v0.3 April 22nd, 2006.

* Changed the markup generated for the colgroup columns from "id" to "class" so that the tag can be used many times on the same page without triggering a validation warning of multiple instances of the same id. 

v0.2 March 28th, 2006.

* Added a way of only listing a certain span of lines from the given source file.
* Added a way of highlighting certain rows in the listing.
* Added highlighting of odd/even rows.
* Added highlighting of lines pointed at by mouse.
* Changed method of displaying data from an ordered list to tabular data in order to better support line wrapping for long source lines.

v0.1 Implemented the following features&#8230;

* Styled, unordered list from given input file.
* Lightweight markup.
* Correctly indents leading tabs.
* Strips leading and trailing whitespace.
* Preserves blank lines from the source file.
* Strips any tabs out of the middle of lines.
* Customisable title before the listing (can be ommited if not needed).
* Customisable download link after the listing (can be ommited if not needed).

h2. Credits.

This is (loosely) based on "the glx_code v0.3 plugin":http://textpattern.org/plugins/203/glxcode which, in turn, was inspired by "Dunstan's website":http://1976design.com/blog/archive/2004/07/29/redesign-tag-transform/.

The TXP file download integration idea came from "Adam Messinger":http://www.adammessinger.com/.

</div>
# --- END PLUGIN HELP ---
-->
<?php
}

# --- BEGIN PLUGIN CODE ---

// ================== PRIVATE CLASSES & FUNCTIONS FOLLOW ===================

abstract class _sed_listing_generator {
	//
	//	Line generation vars...
	//
	protected $listing_body = '';
	protected $highlight_classes = '';
	protected $tab_class = '';
	protected $stripe_class = '';
	
	//
	// Common vars...
	//
	protected $highlight1_array = array();
	protected $highlight2_array = array();
	protected $highlight3_array = array();
	protected $use_highlights = false;
	protected $dir = '';
	protected $file = '';
	
	//
	//	List heading vars...
	//
	protected $list_text = '';
	protected $list_num = '';
	protected $list_class = '';
	protected $sum_text = '';
	protected $default_title_string = '';
	
	//
	//	Download link vars...
	//
	protected $default_link_string = '';
	
	protected function count_initial_tabs($string) {
		// output variable...
		$out_tabs			= 0;

		// private locals...
		$pv_len    		= strlen($string);
		$pv_pos    		= 0;
		$pv_continue	= 1;

		while( (1==$pv_continue) && ($pv_pos<$pv_len) ) {
			$pv_char = $string{$pv_pos};
			if( "\t" == $pv_char )
				$out_tabs+=1;
			else
				$pv_continue=0;
			$pv_pos+=1;
			}
		return $out_tabs;
		}

	public function prep_highlights( $highlight1 , $highlight2 , $highlight3 ) {
		//
		//	Prepare the highlight arrays...
		//
		if( !empty($highlight1) ) {
			$this->use_highlights = true;
			$this->highlight1_array = explode( ',', $highlight1 );
			}
		if( !empty($highlight2) ) {
			$this->use_highlights = true;
			$this->highlight2_array = explode( ',', $highlight2 );
			}
		if( !empty($highlight3) ) {
			$this->use_highlights = true;
			$this->highlight3_array = explode( ',', $highlight3 );
			}
		}
	
	public function set_title( $file, $dir, $list_text, $list_num, $list_class, $sum_text ) {
		$this->dir = $dir;
		$this->file = $file;
		$this->list_text = $list_text;
		$this->list_num = $list_num;
		$this->list_class = $list_class;
		$this->sum_text = $sum_text;
		
		if( !empty($list_text) )	{
			if( !empty($list_num) )
				$this->default_title_string = $list_text.' '.$list_num.': '.$file;
			else
				$this->default_title_string = $list_text.': '.$file;
			}
		}
		
	public function set_link( $link_text, $link_title, $show_count , $full_filename) {
		global $prefs, $siteurl;
		
		//		
		// add in the link to the file if necessary
		//
		if( !empty($link_text) ) {
			$match_dir = $prefs['path_to_site'].DS.$this->dir;
			if( $prefs['file_base_path'] == $match_dir ) {
				//
				//	Downloading from the TXP managed directory of files so get the listing through the core
				// download routine...
				//
				$content_string = (!empty($show_count) ) ? $link_text.'<br/>['.$show_count.'<txp:file_download_downloads />]' : $link_text ;
				$dl_link = file_download_link( array('filename'=>$this->file.'.txt'), $content_string );
				$this->default_link_string = doTag( $dl_link, 'p', $this->list_class )."\n";
				}
			else {
				//
				//	Retain the original link code as it allows title attribute whereas the 
				// core routine doesn't		
				//
				$this->default_link_string = doTag( ("<a href=\"http://".$siteurl.'/'.$this->dir.'/'.$this->file.".txt\" title=\"".$link_title."\">".$link_text."</a>"), 'p', $this->list_class )."\n";
				}
			}

		}
		
	protected function set_css_classes_and_prep_line( $line_number, $line ) {
		//
		//	clean up the line ending and encode for html display.
		//
		$line = htmlspecialchars( rtrim($line) );	

		//
		// Process tabs at the start of the line...
		//
		$tab_count = $this->count_initial_tabs( $line );
		$this->tab_class = 'tab'.$tab_count;

		//
		// Mark-up odd lines to allow for striped tables in the style sheet...
		//
		$this->stripe_class = '';
		if( 1==($line_number & 1) ) 
			$this->stripe_class = 'odd';
		
		//
		// Is this line in the highlight arrays?
		//
		$this->highlight_classes = '';
		if( $this->use_highlights ) {
			if( in_array( $line_number, $this->highlight1_array ) ) 
				$this->highlight_classes .= ' hi1';
			if( in_array( $line_number, $this->highlight2_array ) )
				$this->highlight_classes .= ' hi2';
			if( in_array( $line_number, $this->highlight3_array ) )
				$this->highlight_classes .= ' hi3';
			$this->highlight_classes = ltrim ($this->highlight_classes, ' ');
			}

		//
		// Process whitespace in the line...
		// Trim starting tabs.
		// Trim all trailing whitespace
		// Replace mid-line tabs with spaces.
		//
		$line = ltrim( $line,"\t" );
		$line = str_replace( "\t", " ", $line );

		//
		//	If the line is blank, force to a space to preserve a blank line in the listing...
		//
		if( ''== $line )
			$line = '&#160;';

		return $line;
		}
		
	abstract function add_line( $line_number, $line );
	abstract function dump_listing( $wraptag, $class );
	abstract function identify();
	}

//----- Specializations for TABLE output. ------
class _sed_table_generator extends _sed_listing_generator {
	protected $line_numbers = true;

	private function generate_row( $wrap , $line_num , $line , $row_class , $line_cell_class ) 
		{
		if( $this->line_numbers )
			$pv_line_num_cell = doTag( $line_num, $wrap, '' );
		else
			$pv_line_num_cell = '';
		$pv_line_cell = doTag( $line, $wrap, $line_cell_class );

		return doTag( $pv_line_num_cell.$pv_line_cell, 'tr', $row_class )."\n";
		}

	public function identify() { 
		return '_sed_table_generator'; 
		}

	public function set_options( $options )
		{
		if( array_key_exists( 'line_nums' , $options ) )
			$this->line_numbers = ('0' == $options['line_nums'] ) ? false : true ;
		}
		
	public function add_line( $line_number, $line )	{
		$line = $this->set_css_classes_and_prep_line( $line_number, $line );
		
		//
		//	Prep the line number...
		//
//		$line_number = str_pad($line_number, 4, '0', STR_PAD_LEFT);

		//
		//	Aggregate the CSS class names for use in the table output...
		//
		if( !empty( $this->highlight_classes ) )
			$line_classes = (!empty($this->stripe_class)) ? $this->stripe_class.' '.$this->highlight_classes : $this->highlight_classes;
		else
			$line_classes = $this->stripe_class;

		//
		//	Generate a table row for this line...
		//
		$this->listing_body .= $this->generate_row( 'td' , $line_number , $line , trim( $line_classes ) , $this->tab_class );
		}

	public function dump_listing( $wraptag, $class ) {
		//
		// Process the title block...
		//
		$caption = doTag( $this->default_title_string, 'caption', '' )."\n";
		if( $this->line_numbers )
			{
			$colgroup = doTag( "<col class=\"line-no\" /><col class=\"line\" />", 'colgroup', '') . n;
			$header   = doTag( "<tr><th>#</th><th>Code</th></tr>", 'thead', '') . n;
			}
		else{
			$colgroup = doTag( "<col class=\"line\" />", 'colgroup', '') . n;
			$header   = doTag( "<tr><th>Code</th></tr>", 'thead', '') . n;
			}

		//
		//	Dump the body of the table...
		//
		$body 	 = doTag( $this->listing_body, 'tbody', '');

		//
		//	Put the table parts together...
		//
		$result 	 = doTag( "\n".$caption.$colgroup.$header.$body, 'table', $this->list_class, ' summary="'.$this->sum_text.' '.$this->file.'"' )."\n";
	
		//
		//	Add in the download link (if any!)...
		//
		$result .= $this->default_link_string;
	
		//
		//	Wrap up the whole bundle and return it...
		//
		$result = doTag( "\n".$result, $wraptag , $class );
		return $result;
		}
	}

//----- Specializations for ORDERED LIST (OL) output. ------
class _sed_ol_generator extends _sed_listing_generator {
	protected $first_line_number = -1;
	
	public function identify() { 
		return '_sed_ol_generator'; 
		}

	public function set_options( $options )
		{
		//	This implementation doesn't take any options.
		}

	public function add_line( $line_number, $line )	{
		$line = $this->set_css_classes_and_prep_line( $line_number, $line );
		
		//
		//	On first call, record the line number for later use in kick-starting the OL listing at the correct number...
		//
		if( -1 == $this->first_line_number )
			$this->first_line_number = $line_number;

		//
		//	Aggregate the CSS classes for OL output...
		//
		if( !empty( $this->highlight_classes ) )
//			$line_classes = (!empty($this->stripe_class)) ? $this->stripe_class.' '.$this->highlight_classes : $this->highlight_classes;
			$line_classes = (!empty($this->stripe_class)) ? $this->stripe_class.' '.$this->highlight_classes.' '.$this->tab_class : $this->highlight_classes.' '.$this->tab_class;
		else
//			$line_classes = $this->stripe_class;
			$line_classes = $this->stripe_class.' '.$this->tab_class;
		
		//
		//	Add an <li></li> entry for this source line...
		//
//		$this->listing_body .= '<li class="'.trim( $line_classes ).'">'.$line."</li>\n";
		$this->listing_body .= '<li class="'.trim( $line_classes ).'"><code>'.$line."</code></li>\n";
//		$this->listing_body .= '<li class="'.trim( $line_classes ).'"><code class="'.$this->tab_class.'">'.$line."</code></li>\n";
//		$this->listing_body .= '<li class="'.trim( $line_classes ).'"><span class="'.$this->tab_class.'">&#160;</span><code>'.$line."</code></li>\n";
		}

	public function dump_listing( $wraptag, $class ) {
		//
		//	Add the title...
		//
		$result = doTag( $this->default_title_string , 'p' , $this->list_class.'_title' );

		//
		//	Write the heading of the OL. Use the stashed first line number.
		// If it is not 1 (the standard value) use the deprecated START="number" attribute to get the numbering right.
		// It works but doesn't validate in strict xhtml.
		//
		if( 1 != $this->first_line_number )
			$result .= "\n<ol start=\"".$this->first_line_number.'" class="'.$this->list_class."\">\n";
		else
			$result .= "\n<ol class=\"".$this->list_class."\">\n";

		//
		//	Append the listing body and close the ordered list...
		//
		$result .= $this->listing_body."</ol>\n";

		//
		//	Append the download link (if any)...
		//
		$result .= $this->default_link_string;
		
		//
		//	Wrap the whole bundle up and return it...
		//
		$result = doTag( $result, $wraptag , $class );
		return $result;
		}
	}
	
//----- Creates a listing generator of the correct type -----
function _sed_generator_factory( $list_type )	{
	switch( $list_type ) {
		case 'ol'	:	$class_name = '_sed_ol_generator';
						break;
		default		:	$class_name = '_sed_table_generator';
		}
	$generator = new $class_name;
	return $generator;
	}
	
	
// ================== CLIENT-SIDE TAGS FOLLOW ===================
	
function sed_display_code($atts)	{
	$result = "";

	global $prefs;
	$offset = strlen( $prefs['path_to_site'] ) + 1;
	$default_path = substr( $prefs['file_base_path'] , $offset );

	// process attribute variables...
	extract( lAtts( array( 
		'file'		=> '',				// Needed: Name of the file to process.
		'dir'		=> $default_path,  	// Optional: Directory to use to look for file.
		'list_type' => 'table',
		'list_text' => 'Listing', 		// Optional: Text used to tag the title of the listing. Set this to '' to omit the title.
		'list_no' 	=> '',				// Optional: Any non-empty value will be placed after the list_text variable in the title. 
		'show_count'=> '',
		'listclass' => 'sed_dc',
		'errorclass'=> 'sed_dc_error',
		'err_text'	=> 'was not found.',
		'class'		=> 'sed_dc_wrap',	// Optional: Name of class to use for the wrap tag.
		'wraptag'	=> 'div',			// Optional: Name of the tag to use to wrap the listing.
		'start'		=> '1',
		'end'		=> '',
		'line_nums' => '1',				// Optional: Set to 0 to turn off line numbers.
		'highlight1'=> '-1',			// Optional: list of line numbers to tag with highlight class 1. (Omit to tag no lines).
		'highlight2'=> '-1',			// Optional: list of line numbers to tag with highlight class 1. (Omit to tag no lines).
		'highlight3'=> '-1',			// Optional: list of line numbers to tag with highlight class 1. (Omit to tag no lines).
		'sum_text'	=> 'This table lists the contents of the file',
		'link_text' => 'Download this code',	// Optional: Text to use when printing the download option (set to '' to disable download.)
		'link_title'=> 'Downloads the above listing as a text file.' // Optional: Text used to title the download link (if enabled.)
		), $atts));

	$pv_filename = $dir.DS.$file.'.txt';

	//
	// Clean up the start and end line numbers...
	//
	if( !is_numeric( $start ) )
		$start = 1;
	else {
		$start = intval( $start );
		if( $start < 0 )
			$start = 1;
		}
	if( !is_numeric( $end ) )
		$end = 1000000;	
	else {
		$end = intval( $end );
		if( ($end < 0) || ($end < $start) )
			$end = 1000000;	
		}

	//
	//	Create a listing generator of the correct type...
	//
	$generator = _sed_generator_factory( $list_type );

	$generator->set_options( array( 'line_nums' => $line_nums ) );
	$generator->prep_highlights( $highlight1 , $highlight2 , $highlight3 );
	$generator->set_title( $file, $dir, $list_text, $list_no, $listclass, $sum_text );
	$generator->set_link ( $link_text, $link_title, $show_count , $pv_filename );
	
	//
	// Open the file and get it into an array of lines...
	//
	$file_content = file($pv_filename);
	if ( false == $file_content )
		return "<p class=\"".$errorclass."\"><strong>".$pv_filename." ".$err_text."</strong></p>";
	
//	$line_count = count( $file_content );
	$end = min( $end, count( $file_content ) );
	for ($i=($start-1); $i < $end; $i++) 
		$generator->add_line( ($i+1) , $file_content[$i] ); 
		
//	$result = $generator->dump_listing( $wraptag, $class );
//	return $result;
	return $generator->dump_listing( $wraptag, $class );
	}

# --- END PLUGIN CODE ---

?>
