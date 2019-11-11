jQuery("#jmb_gallery").justifiedGallery({
	rowHeight: 220,
	maxRowHeight: 200,
	margins: 10,
});

jQuery('#jmb_gallery').lightGallery({
	thumbnail:true,
	loadYoutubeThumbnail: true,
	youtubePlayerParams: { modestbranding: 0, showinfo: 0, controls: 1, rel: 1, autoplay: true },
	autoplyFirstVideo: true,
	autoplayVideoOnSlide: true,
    youtubeThumbSize: 'default',
    loadVimeoThumbnail: true,
    vimeoThumbSize: 'thumbnail_medium',
}); 

