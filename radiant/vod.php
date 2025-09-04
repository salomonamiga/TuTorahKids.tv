<?php
$video_id=$_GET["mu"];
$title=$_GET[""];
 ?>
<!DOCTYPE html>
<!-- Our HTML5 document must start with a valid DOCTYPE -->
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <title><?php echo $title ; ?></title>

  <style>
      /* This CSS is required to avoid layout issues */
        html,

        body {
        height: 100%;
        width: 100%;
        overflow: hidden;
        margin: 0;
        padding: 0;

      }
      .rmp-poster {
      display: none !important;
      }
    </style>
</head>
<body>
  <!-- Add a player container with a unique id - player UI elements will be appended in this container -->
  <div id="rmpPlayer"></div>.
  <!-- Set up async player configuration options -->
  <script>
    // First we must provide a streaming source to the player - in this case an HLS feed
    var src = {
      //hls: 'https://x1.streamgates.net/tutorah_live/live_abr/playlist.m3u8',
    //hls: 'https://multix1.akamaized.net/tutorah_live/live_abr/playlist.m3u8',
    //hls: 'https://tutorah.streamgates.net/tutorah_vod/<?php echo $video_id; ?>.smil/playlist.m3u8',
    hls: 'https://tvod.streamgates.net/TutorahVOD/<?php echo $video_id; ?>.smil/playlist.m3u8',
      contentTitle: "<?php echo $title ; ?>"
    };


    var labels = {
   ads: {
     controlBarCustomMessage: 'RMP ad',
     skipMessage: 'Skip this ad',
     skipWaitingMessage: 'Skip this ad in'
   }
 };
 var labels = {
  ads: {
    controlBarCustomMessage: 'Ad',
    skipMessage: 'Skip ad',
    skipWaitingMessage: 'Skip ad in',
    textForClickUIOnMobile: 'Learn more'
  }
};

    // Then we set our player settings
    var settings = {
      licenseKey: 'd3NhYnFqZGpsZUAxNTgwNzY0',
      src: src,
      autoHeightMode: true,
      detectAutoplayCapabilities: true,
      autoplay: false,
      pip: true,
	  muted: false,
	  initialVolume: 0.5,
	  forceInitialVolume: true,
	  quickRewind: 10,
	  quickForward: 10,
      airplay: true,
      googleCast:true,
      iframeMode: true,
      iframeAllowed: true,
      gaTrackingId: 'UA-118904852-3',
      gaCategory: 'TuTorah Kids VOD',
      gaLabel: 'VOD',
      gaEvents: ['context', 'ready', 'playerstart', 'error', 'adimpression', 'adloadererror', 'aderror'],
      // The player will automatically resize itself based on context and those reference width/height values
      width: 640,
      height: 360,
      sharing: false,
      preload: 'auto',
      //ads:  false,
      //adLoadVastTimeout:5000,
    //  adParser: 'rmp-vast',
  //    adSkipButton: true,
  //    adSkipOffset: 4,
    //  labels: labels,
    //  adTagUrl: 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/single_ad_samples&ciu_szs=300x250&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&cust_params=deployment%3Ddevsite%26sample_ct%3Dskippablelinear&correlator=',
//      adCountDown:true,
      // Let us select a skin
      skin: 's2',
      asyncElementID: 'rmpPlayer'

      // By default, player does not preload any content when initialised
      // Enabling preloading generally helps with faster startup

      // Let us add a nice poster frame to our player



      // Here we pass the ID of the player container so that the core library may automatically initialise player when it finishes loading


    };
  //  var labels = {
  //    ads: {
    //    controlBarCustomMessage: 'Ad',
    //    skipMessage: 'Skip ad',
  //      skipWaitingMessage: 'Skip ad in',
  //      textForClickUIOnMobile: 'Learn more'
//      }
//    };

    // We push the player settings to a global rmpAsyncPlayers variable
    if (typeof window.rmpAsyncPlayers === 'undefined') {
      window.rmpAsyncPlayers = [];
    }
    window.rmpAsyncPlayers.push(settings);
  </script>
  <!-- Include Radiant Media Player JavaScript at the bottom of your page - note the async attribute -->
  <script async src="https://cdn.radiantmediatechs.com/rmp/5.12.9/js/rmp.min.js"></script>
</body>
</html>
