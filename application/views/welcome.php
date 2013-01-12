<div class="container">
	<? if (isset($error)): ?>
	<div class="alert alert-error"><strong>Oh no!</strong> Something went wrong during authentication. Maybe trying again will help?</div>
	<? endif; ?>
	<div class="hero-unit">
		<h2>Commits Under Review</h2>
		<p>We look at your Github commits for the past year and see how well you've done.</p>
		<a href="<?= github_oauth_url() ?>" class="btn"><img id="github-logo" src="https://raw.github.com/github/media/master/octocats/blacktocat-32.png" alt="github logo" /> Login using Github</a>
	</div>
</div>