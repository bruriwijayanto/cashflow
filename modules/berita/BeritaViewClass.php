<?php
Class BeritaViewClass Extends ViewClass  {
	function frontlist($data){
		$content = "";
		foreach ($data['berita'] as $row) {
			$url = ROOT_URL."detail/berita/".$row['idberita']."/".$this->url->friendlyURL($row['title']).".htm";
			$content .= "<h3><a href='$url'>".$row['title']."</a></h3> 
						<p>".$row['content']."</p>";
		}
		$nrw = $data['numrows'];
		//([^/]+)/([^/]+)/([^/]+)/pages.htm
		$content .= $this->pagging->displayLink($nrw, $data['numperpage']);
		
		$define = array (
						 'sitetitle' 	=> SITE_TITLE,	
						 'sitekey' 		=> SITE_KEY,
						 'sitedesc' 	=> SITE_DESC,						
						 'pagetitle'	=> 'Daftar Berita',
						 'pagecontent'	=> $content,
						 'home'			=> ROOT_URL,
						 'tweetacc' 	=> TWEET_ACC,
						 'fbacc' 		=> FB_ACC,
						 'googleacc' 	=> GOOGLE_ACC,
						 'contactaddr' 	=> CONTACT_ADDR,
						 'contacttelp' 	=> CONTACT_TELP,
						 'contactweb' 	=> CONTACT_WEB,
						 'contactfb' 	=> FB_ACC,
						 'contactfax' 	=> CONTACT_FAX,
						 'contactemail' => CONTACT_EMAIL,
						 'hotline' 		=> HOTLINE,					 						 
				 		 'themepath'  	=> THEME_URL,
                );
		$this->parse(THEME.'/detail.html',$define);	
	}

	
}