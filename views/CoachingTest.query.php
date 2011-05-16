<? $this->displayView('components/header.php'); ?>
			<div class="content" style="width: 960px;">
				<div id="MotivadoPlayer">
					<p>
						To view this page ensure that Adobe Flash Player version 10.0.0 or greater is installed.
					</p>
					<script type="text/javascript">
						document.write('<a href="http://www.adobe.com/go/getflashplayer"><img src="' + ((document.location.protocol == 'https:') ? 'https://' :   'http://') + 'www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>');
					</script>
				</div>
				<div id="InteractionResults" style="padding: 12px;">
					<table>
						<tr>
							<td>
								<? echo $this->localize('Loading Interaction Results...'); ?>

							</td>
						</tr>
					</table>
				</div>
				<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
				<script type="text/javascript" src="http://jquery.thewikies.com/swfobject/jquery.swfobject.1-1-1.min.js"></script>
				<script type="text/javascript">
				function MotivadoPlayer(config) {
					if (config.product == undefined || config.baseServiceUrl == undefined) {
						return alert('Missing required parameters!');
					}
					
					jQuery('#' + (config.element || 'MotivadoPlayer')).flash({
						swf: (config.basePlayerUrl || config.baseServiceUrl + 'player/') + (config.player || 'MotivadoPlayer.swf'),
						width: config.width || 960,
						height: config.height || 350,
						flashvars: {
							product: config.product,
							baseServiceUrl: config.baseServiceUrl,
							baseVideoUrl: config.baseVideoUrl || config.baseServiceUrl + 'videos/',
							autoPlay: config.autoPlay || 'true',
							debugMode: config.debugMode || 'false'
						}
					});
				}
				
				function showInteractionResults(baseServiceUrl) {
					jQuery.getJSON(baseServiceUrl + 'getInteractionResults', function(data) {
						var items = [];
						jQuery.each(data, function(key, value) {
							items.push('<tr><td>' + key + '</td><td><table><tr><td><? echo $this->localize('Data:'); ?></td><td>' + value.data + '</td></tr><tr><td><? echo $this->localize('Value:'); ?></td><td>' + value.value + '</td></tr></table></td></tr>');
						});
						jQuery('#InteractionResults table').replaceWith('<table class="decoded">' + items.join('') + '</table>');
					});
				}
				
				jQuery(document).ready(function() {
					MotivadoPlayer({
						baseServiceUrl: '<? echo $this->getConfiguration('host'); ?>/ui/',
						baseVideoUrl: 'http://motivado.de/videos/',
						basePlayerUrl: '<? echo $this->getConfiguration('host'); ?>/player/',
						player: 'CoachingPlayer.swf',
						product: '<? echo $product; ?>'
					});
					
					setInterval(function() {
						showInteractionResults('<? echo $this->getConfiguration('host'); ?>/ui/');
					}, 5000);
				});
				</script>
			</div>
<? $this->displayView('components/footer.php'); ?>