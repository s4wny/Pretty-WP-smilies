/**
 * Convert smiley code to the icon graphic file equivalent.
 *
 * You can turn off smilies, by going to the write setting screen and unchecking
 * the box, or by setting 'use_smilies' option to false or removing the option.
 *
 * Plugins may override the default smiley list by setting the $wpsmiliestrans
 * to an array, with the key the code the blogger types in and the value the
 * image file.
 *
 * The $wp_smiliessearch global is for the regular expression and is set each
 * time the function is called.
 *
 * The full list of smilies can be found in the function and won't be listed in
 * the description. Probably should create a Codex page for it, so that it is
 * available.
 *
 * @global array $wpsmiliestrans
 * @global array $wp_smiliessearch
 * @since 2.2.0
 */
function smilies_init() {
	global $wpsmiliestrans, $wp_smiliessearch;

	// don't bother setting up smilies if they are disabled
	if ( !get_option( 'use_smilies' ) )
		return;

		
    //Sony?'s aka Sawnys's mod starts here. Some smilies dosen't have any replacement, yet.
	if ( !isset( $wpsmiliestrans ) ) {
		$wpsmiliestrans = array(
		':facepalm:' => 'fb/facepalm.gif',
		':mrgreen:'  => 'icon_mrgreen.gif',
		':neutral:'  => 'fb/noexpression.gif',
		':twisted:'  => 'fb/devil.gif',
		  ':arrow:'  => 'icon_arrow.gif',
		  ':shock:'  => 'fb/ohmy.gif',
		  ':smile:'  => 'fb/happy.gif',
		    ':???:'  => 'fb/confused.gif',
		   ':lala:'  => 'fb/innocent.gif',
		   ':cool:'  => 'fb/cool.gif',
		   ':evil:'  => 'fb/devil.gif',
		   ':grin:'  => 'fb/grin.gif',
		   ':idea:'  => 'icon_idea.gif',
		   ':oops:'  => 'fb/skamsen.gif',
		   ':razz:'  => 'fb/tongue.gif',
		   ':roll:'  => 'fb/rolleyes.gif',
		   ':wink:'  => 'fb/wink.gif',
		    ':cry:'  => 'fb/cry.gif',
		    ':eek:'  => 'fb/w000t.gif',
		    ':lol:'  => 'fb/lol.gif',
		    ':mad:'  => 'fb/rant.gif',
		    ':sad:'  => 'fb/sad.gif',
			':yes:'  => 'fb/yes.gif',
		      '8-)'  => 'fb/cool.gif',
		      '8-O'  => 'fb/w000t.gif',
		      ':-('  => 'fb/sad.gif',
		      ':-)'  => 'fb/happy.gif',
		      ':-/'  => 'fb/confused.gif',
		      ':-D'  => 'fb/grin.gif',
		      ':-P'  => 'fb/tongue.gif',
		      ':-o'  => 'fb/ohmy.gif',
		      ':-x'  => 'fb/rant.gif',
		      ':-|'  => 'fb/noexpression.gif',
		      ';-)'  => 'fb/wink.gif',
		       '8)'  => 'fb/cool.gif',
		       '8O'  => 'fb/w000t.gif',
		       ':('  => 'fb/sad.gif',
		       ':)'  => 'fb/happy.gif',
		       ':?'  => 'fb/confused.gif',
		       ':D'  => 'fb/grin.gif',
		       ':P'  => 'fb/tongue.gif',
		       ':o'  => 'fb/ohmy.gif',
		       ':x'  => 'fb/rant.gif',
		       ':|'  => 'fb/noexpression.gif',
		       ';)'  => 'fb/wink.gif',
		      ':!:'  => 'icon_exclaim.gif',
		      ':?:'  => 'icon_question.gif',
		);
	}

	if (count($wpsmiliestrans) == 0) {
		return;
	}

	/*
	 * NOTE: we sort the smilies in reverse key order. This is to make sure
	 * we match the longest possible smilie (:???: vs :?) as the regular
	 * expression used below is first-match
	 */
	krsort($wpsmiliestrans);

	$wp_smiliessearch = '/(?:\s|^)';

	$subchar = '';
	foreach ( (array) $wpsmiliestrans as $smiley => $img ) {
		$firstchar = substr($smiley, 0, 1);
		$rest = substr($smiley, 1);

		// new subpattern?
		if ($firstchar != $subchar) {
			if ($subchar != '') {
				$wp_smiliessearch .= ')|(?:\s|^)';
			}
			$subchar = $firstchar;
			$wp_smiliessearch .= preg_quote($firstchar, '/') . '(?:';
		} else {
			$wp_smiliessearch .= '|';
		}
		$wp_smiliessearch .= preg_quote($rest, '/');
	}

	$wp_smiliessearch .= ')(?:\s|$)/m';
}