<div class="wrap">

	<h2><?php echo self::PLUGIN_SHORT_NAME ?> Console Debugger</h2>
	<h3 id="bugfu-subtitle">BugFu lets you log from PHP directly to your Browser JavaScript Console<br>
		- Meant as an aid to those practicing the ancient art of debugging -</h3>

	<div id="bugfu-wrap">

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<?php $bugfu_status = get_option(self::OPTION_NAME_STATUS); ?>
			<input type="hidden" name="<?php echo self::OPTION_NAME_STATUS ?>" id="<?php echo self::OPTION_NAME_STATUS ?>" value="<?php echo $bugfu_status ?>">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Turn <?php echo self::PLUGIN_SHORT_NAME ?> <?php if( $bugfu_status == '1' ){ echo 'Off'; }else{ echo 'On'; } ?>">
			<span id="bugfu-status" class="bugfu-<?php if( $bugfu_status == '1' ){ echo 'on'; }else{ echo 'off'; } ?>">BugFu <?php if( $bugfu_status == '1' ){ echo 'ON'; }else{ echo 'OFF'; } ?></span>
			<div id="bugfu-disclaimer">
				To avoid performance and security issues, before you go to production<br>
				remove all your log calls from the WordPress PHP code and turn BugFu Off.
			</div>
		</form>

		<h4>1) HOW TO CHECK IF <?php echo strtoupper(self::PLUGIN_SHORT_NAME) ?> IS WORKING</h4>
		<p>Open your browser console, if you see this header, <?php echo self::PLUGIN_SHORT_NAME ?> is working properly<br>
		<code>
			<?php echo self::LOG_HEADER_BAR ?><br>
			<?php echo self::LOG_HEADER ?><br>
			<?php echo self::LOG_HEADER_BAR ?>
		</code>
		</p>

		<h4>2) HOW TO OPEN YOUR BROWSER JAVASCRIPT CONSOLE</h4>
		<p>If you've never used the JavaScript Console before, here's how you open it:
			<ul>
				<li><strong>Chrome PC</strong> shift+ctrl+j &nbsp; <strong>Chrome Mac</strong> alt+cmd+j</li>
				<li><strong>Firefox PC</strong> shift+ctrl+k &nbsp; <strong>Firefox Mac</strong> alt+cmd+k</li>
				<li><strong>Safari PC</strong> shift+ctrl+c &nbsp; <strong>Safari Mac</strong> alt+cmd+c</li>
			</ul>
		</p>

		<h4>3) HOW TO USE <?php echo strtoupper(self::PLUGIN_SHORT_NAME) ?> WITH WORDPRESS</h4>
		<p>Call the log static method from wherever you are within the WordPress PHP code<br>
		<code>
			&lt;?php /* WORDPRESS CODE HERE */<br>
			<br>
			<strong>
				# Call it with no arguments to only output some backtrace info<br>
			</strong>
			<?php echo self::PLUGIN_SHORT_NAME ?>::log();<br>
			<br>
			<strong>
				# Call it with a string argument to output that string content<br>
			</strong>
			<?php echo self::PLUGIN_SHORT_NAME ?>::log($my_string_content);<br>
			<br>
			<strong>
				# Call it with a non-string argument to output the structured<br>
				# representation of that argument - it uses <a href="http://php.net/manual/en/function.var-export.php" target="_blank">var_export()</a>
			</strong>
			<br>
			<?php echo self::PLUGIN_SHORT_NAME ?>::log($my_object-array-variable);<br>
			<br>
			<strong>
				# Call it with the second optional argument set to "false"<br>
				# to turn off the backtrace info (which is on by default)
			</strong>
			<br>
			<?php echo self::PLUGIN_SHORT_NAME ?>::log($my_content, false);<br>
			<br>
		</code>
		</p>

	</div>
</div>
