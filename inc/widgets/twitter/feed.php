<?php 

class Twitter_Feed extends WP_Widget {
	
	function Twitter_Feed() {
		$widget_opts = array( 'description' => __('Use this widget is to show the tweets of a specific user.') );
		parent::WP_Widget(false, 'Twitter Feed', $widget_opts);
	}
	function form($instance) {
		 
		$username = (isset($instance['username'])) ? esc_attr($instance['username']) : '';  
		?>
		<p>
			<label>Username: <input class="widefat" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label>
		</p>

		<?php
	}
	function update($new_instance, $old_instance){
		return $new_instance;
	}
	
	function widget($args, $instance) {
		require_once('oauth/twitteroauth.php');
		$tweets = get_transient('tweets');

		if(!$tweets) {
			$args['username'] = (isset($instance['username'])) ? $instance['username'] : '';
			$key = 'PsYqPIz78oVFNAieHZn1pg';
			$secret = 't08PgTwn9JLPhBt3TbGZZakTCavJDq5wK6cb9eU';
			$token = '1361869022-Smh5Dmu0auCoaol9Bhy5CcFMWd5x6vbVFMH8paL';
			$token_secret = 'zoZIhrRztmS6jRqWVQ8DTC7brfhfhvobbGyQUhSI';
			$connection = new TwitterOAuth($key, $secret, $token, $token_secret);
			$tweets = $connection->get('statuses/user_timeline', array('screen_name' => $args['username'], 'count' => 1, 'trim_user' => true, 'exclude_replies' => true, 'include_rts' => false));
			//set_transient('tweets', $tweets);
		}

		if($tweets):
		echo $args['before_widget'];	
		?>
		<div class="inner">
			<header class="header" >
				<h5 class="title"><a href="http://twitter.com/<?php echo $args['username']; ?>" target="_blank" class="twitter-btn"></a></h5>
			</header>
			
			<ul class="twitter-feed">
				<?php foreach($tweets as $tweet): ?>
				<li class="tweet">
					<div class="text">
						<?php echo $tweet['text']; ?>
					</div>
					<div class="meta">
						<span class="time"><?php echo $this->relativeTime($tweet['created_at']); ?></span> 
						<span class="from"><?php _e("from", THEME_NAME); ?></span>
						<a href="http://twitter.com/<?php echo $args['username']; ?>">@<?php echo $args['username']; ?></a>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php echo $args['after_widget']; ?>
		<?php endif;?>	
		<?php 
	}

	function relativeTime($date) {
		$diff = time() - strtotime($date);
		if ($diff<60)
			return $diff . " second" . $this->plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<60)
			return $diff . " minute" . $this->plural($diff) . " ago";
		$diff = round($diff/60);
		if ($diff<24)
			return $diff . " hour" . $this->plural($diff) . " ago";
		$diff = round($diff/24);
		if ($diff<7)
			return $diff . " day" . $this->plural($diff) . " ago";
		$diff = round($diff/7);
		if ($diff<4)
			return $diff . " week" . $this->plural($diff) . " ago";
		return "on " . date("F j, Y", strtotime($date));
	}

	function plural($num) {
		if ($num != 1) return "s";
	}
}

register_widget('Twitter_Feed');



?>
