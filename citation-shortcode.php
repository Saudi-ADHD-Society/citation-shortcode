<?php
/*
Plugin Name: Citation Shortcode
Plugin URI: https://github.com/Saudi-ADHD-Society/citation-shortcode
Description: Creates non-theme specific citation shortcodes for adhd research micro-site
Version: 1.0.9
Author: Jeremy Varnham
Author URI: https://abuyasmeen.com
License: CC0 1.0 Universal
Text Domain: adhd-citation-shortcode
*/

/*
 * Research citation shortcode
 * Uses h-cite microformat markup 
 * e.g. using Formidable Forms as input:
 * [research_citation style="APA" pubtype="journal" authors="[foreach 104][98] [99] [100],[/foreach]" year="[111]" title="[102]" volume="[112]" issue="[113]" journal="[109]" shortjournal="[110]" startpage="[114]" endpage="[115]" articlenum="" doi="[117]"]
 *
 * @see: https://microformats.org/wiki/h-cite
 * @see: https://microformats.org/wiki/h-card
 */
function adhd_research_citations( $atts, $string="" ) {

	$atts = shortcode_atts(
		array(
			'style'         => "APA", // currently just APA citation
			'pubtype'       => "journal", // currently just journal citation
			'authors'       => null,
			'year'          => null,
			'title'         => null,
			'volume'        => null,
			'issue'         => null,
			'journal'       => null,
			'shortjournal'  => null,
			'startpage'     => null,
			'endpage'       => null,
			'articlenum'    => null,
			'doi'           => null,
		), $atts, 'adhd-citation-terms' );			 
							
		$authors_processed_array = adhd_research_citations_process_authors( $atts['authors'] );
		$reference               = adhd_research_citations_apa_format( $authors_processed_array, $atts['year'], $atts['title'], $atts['volume'], $atts['issue'], $atts['journal'], $atts['shortjournal'], $atts['startpage'], $atts['endpage'], $atts['articlenum'], $atts['doi'] );
				
		return $reference;                   	
}
add_shortcode('research_citation', 'adhd_research_citations');


function adhd_research_citations_process_authors( $authors_comma_string ) {
	
	$authors_comma_string = substr($authors_comma_string, 0, -1); // omit ',' for final name
	$authors_array        = explode( ',', $authors_comma_string );

	foreach ( $authors_array as $author_full_name ) {
		$author_name_array = explode( ' ', $author_full_name );
		$author_name_count = count( $author_name_array );
		
		$author_name_1    = $author_name_array[0];
		$author_name_2    = ( $author_name_count >2 ? $author_name_array[1] : null );
		//$author_name_3    = ( $author_name_count >3 ? $author_name_array[2] : null );

		$author_name_last = $author_name_array[$author_name_count-1];
		
		$author_name_1_initial = ( $author_name_1 ? $author_name_1[0] : null );
		$author_name_2_initial = ( $author_name_2 ? $author_name_2[0] : null );
		$author_name_3_initial = ( $author_name_3 ? $author_name_3[0] : null );						
	
		$authors_processed_array[] = array(
			'first_name'         => $author_name_1,
			'first_initial'      => $author_name_1_initial,
			'second_name'        => $author_name_2,
			'second_initial'     => $author_name_2_initial,
			'third_name'         => $author_name_3,
			'third_initial'      => $author_name_3_initial,
			'last_name'          => $author_name_last,
		);
	}
	return $authors_processed_array;
}

function adhd_research_citations_apa_format( $authors_processed_array, $year, $title, $volume, $issue, $journal, $shortjournal, $startpage, $endpage, $articlenum, $doi ) {

	/* AUTHORS
	 *
	 * Note on number of authors in APA 7 formatting:
	 * @see: https://owl.purdue.edu/owl/research_and_citation/apa_style/apa_formatting_and_style_guide/reference_list_basic_rules.html
	 *
	 * Give the last name and first/middle initials for all authors of a particular work up to and including 20 authors 
	 * (this is a new rule, as APA 6 only required the first six authors). Separate each author’s initials from the next 
	 * author in the list with a comma. Use an ampersand (&) before the last author’s name. If there are 21 or more
	 * authors, use an ellipsis (but no ampersand) after the 19th author, and then add the final author’s name.
	 */
	 
	$count = count( $authors_processed_array );
	
	foreach ( $authors_processed_array as $key => $author_array ) {
		$prefix  = ( $count-1 === $key && $count > 1 && $count <= 20 ? '& ' : null ); // Add ampersand before final author for 2-20 authors
		$elipsis = ( $count-1 === $key && $count > 20 ? '&#8230; ' : null ); // Add elipsis before final author for 21+ authors
		
		$first_initial = ( $author_array['first_initial'] ? $author_array['first_initial'] . '.' : null );
		$second_initial = ( $author_array['second_initial'] ? $author_array['second_initial'] . '.' : null );
		//$third_initial = ( $author_array['third_initial'] ? $author_array['third_initial'] . '.' : null ); // no third initial in APA ?
		
		$apa_authors_array[] = $elipsis . $prefix . '<abbr rel="author" class="p-author h-card" title="' . $author_array['first_name'] . ' ' . $author_array['last_name'] . '">' . $author_array['last_name'] . ', ' . $first_initial . $second_initial . '</abbr>';
	}
	
	// Only keep authors 1-20 and final author (total 21)
	if ( $count > 20 ) {
		for ( $i = 0; $i < 20; $i++) {
			$apa_authors_array_20limit[$i] = $apa_authors_array[$i];
		}
		$apa_authors_array_20limit[21] = end( $apa_authors_array );
		$apa_authors_array = $apa_authors_array_20limit;
	}
	$apa_authors_list = implode( ', ', $apa_authors_array ) . ' ';
	
	/*
	 * DATE
	 *
	 * The markup format expects YYYY-MM-DD, but as this is different from APA style,
	 * just the year is included, as this is consistent with markup and APA requirements.
	 */
	$year = ( $year ? '(<time class="dt-published">' . $year . '</time>). ' : null ); // YYYY-MM-DD
	
	/* ARTICLE TITLE */
	$title = ( $title ? '<cite class="p-name noitalics">' . $title . '</cite>. ' : null );

	/*
	 * JOURNAL TITLE
	 *
	 * Short title displayed with full title on hover.
	 * If no short title, use full title.
	 */
	$shortjournal = ( $shortjournal ? $shortjournal : $journal );
	$journaltitle = ( $journal ? '<i><abbr title="' . $journal . '">' . $shortjournal . '</abbr></i>, ' : null );

	/* VOLUME AND ISSUE */
	$pubdetails  = ( $volume ? $volume : null );
	$pubdetails .= ( $issue ? '(' . $issue . ')' : null ); 
	
	/*
	 * PAGES or ARTICLE NUMBER
	 *
	 * If just one page (only startpage) then omit the hyphen.
	 * If no pages but article number then include article number.
	 * Otherwise add nothing.
	 */
	if ( $startpage ) {
		$pubdetails .= ( $endpage ? ', ' . $startpage . '-' . $endpage : ', ' . $startpage );
	} else if ( $articlenum ) {
		$pubdetails .= ', ' . $articlenum;
	}
	
	/*
	 * DOI
	 * 
	 * Includes link for the purposes of markup, although not necessary for APA citation style.
	 */	
	$doi = ( $doi ? ', doi: <a class="u-uid" href="https://doi.org/' . $doi . '" target="_blank">' . $doi . '</a>' : '.' );
	
	
	$html  = '<blockquote class="cite_apa h-cite">';
	$html .= $apa_authors_list . ' ' . $year . $title . $journaltitle . $pubdetails . $doi;
	$html .= '</blockquote>';
	
	return $html;
}

	
function trim_trailing_comma( $atts, $string="" ) {

	$atts = shortcode_atts(
		array(
			'authors' => null,
		), $atts, 'adhd-citation-author-list' );
		
		// should generalize and also check what last character is first		
		$authors_comma_string = ( $atts['authors'] ? substr( $atts['authors'], 0, -2) : null ); // omit ', ' (comma and space) for final name
		
		return $authors_comma_string;                   	
}
add_shortcode('trim_trailing_comma', 'trim_trailing_comma');
?>
