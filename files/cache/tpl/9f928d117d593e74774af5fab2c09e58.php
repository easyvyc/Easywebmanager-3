<?php $templateVariables->set_var('item_data', $main_object->call('pages', 'loadPage', array($templateVariables->vars["page_data.id"]))); ?>
<div class="box1">
	<div class="border-top">
		<div class="border-right">
			<div class="border-bot">
				<div class="border-left">
					<div class="left-top-corner">
						<div class="right-top-corner">
							<div class="right-bot-corner">
								<div class="left-bot-corner">
									<div class="inner">
										<h1><?php echo $templateVariables->vars["item_data.title"]; ?></h1>
										
										<div id="path">
										<?php foreach($templateVariables->loops["id_path"] as $id_path_key => $id_path_val){ ?>
										<?php if(!$id_path_val["first"]){ ?>
										&nbsp;&nbsp;»&nbsp;&nbsp;
										<?php } ?>
										<a href="<?php echo $templateVariables->vars["lng"]; ?><?php echo $id_path_val["page_url"]; ?>" title="<?php echo $id_path_val["page_title"]; ?>"><?php echo $id_path_val["title"]; ?></a>
										<?php } ?>
										</div>										
										
										<?php echo $templateVariables->vars["item_data.description"]; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="box alt">
	<div class="border-top">
		<div class="border-right">
			<div class="border-bot">
				<div class="border-left">
					<div class="left-top-corner">
						<div class="right-top-corner">
							<div class="right-bot-corner">
								<div class="left-bot-corner">
									<div class="inner">
										<h3><?php echo $templateVariables->vars["phrases.siulome"]; ?></h3>
										<p>Pets Site is a free websites template created by Templates.com team. This website template is optimized for 1024X768 screen resolution. It is also XHTML &amp; CSS valid.</p>
										<p>The website template goes with two packages ā€“ with PSD source files and without them. PSD source files are available for free for the registered members of Templates.com. The basic package (without PSD is available for anyone without registration).</p>
										<p class="p0">This website template has several pages: <a href="home.html">Home</a>, <a href="about-us.html">About us</a>, <a href="articles.html">Article</a> (with <a href="article.html">Article</a> page), <a href="contact-us.html">Contact us</a> (note that contact us form ā€“ doesnā€™t  work), <a href="sitemap.html">Site Map</a>.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>