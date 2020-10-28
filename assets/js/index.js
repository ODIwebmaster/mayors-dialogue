function App (siteUrl, contentFolderUrl, data, palette) {

  // construct

  this.state = {
    data: data,
    currentDataType: "population",
    scrollPos: null,
    landing: null,
  };
  this.siteUrl = siteUrl;
  this.contentFolderUrl = contentFolderUrl;
  this.palette = palette;
  
  // methods

  this.shuffleCities = function () {
    $(".all-cities .city-prev").shuffle();
  }

  this.fillDataLines = function (cityData) {
    var that = this;
    $(".stat-shape[data-stat-id]").each(function (i, e) {
      var statId = this.dataset.statId;

      $(e).find("svg path[id^='line-']")
        .addClass("city-stat-path")
        .addClass(that.palette +"-stroke-lines-grid");

      // --- Lines with data
      var statData = cityData.stats[statId];
      var statLineNumber = statData.stat;

      // TEMPORARY
      /***********************************************************************************/
      /*********/ var max = 30; /*********************************************************/
      /*********/ statLineNumber = statLineNumber > max ? max : statLineNumber; /*********/
      /***********************************************************************************/

      for (var i = 1; i <= statLineNumber; i++) {
        var line = $(e).find("svg #line-"+ i);
        line
          .removeClass(that.palette +"-stroke-lines-grid")
          .addClass("active")
          .addClass(that.palette +"-stroke-lines-data");
      }
      
      // --- BG
      // ------ Largest data line
      var largestDataLine = $(e).find("svg #line-"+ statLineNumber);
      var parent = $(e).find("svg");
      largestDataLine.css("fill", "rgba(255,255,255,0.45)").prependTo(parent);
      // ------ Most external line
      // var largestDataLine = $(e).find("svg #line-30");
      // var parent = $(e).find("svg");
      // largestDataLine.css("fill", "rgba(255,255,255,0.45)").prependTo(parent);

    });
  }

  this.uniformDescriptionHeights = function () {
    var maxH = 0;
    $("p.description").each(function (i, e) {
      if ($(e).height() > maxH) { maxH = $(e).height(); }
    });
    $("p.description").css("height", maxH +"px");
    $("#compensate-margin").css("margin-top", "-"+ maxH +"px")
  }

  this.switchDataType = function (dataType) {
    var that = this;
    $(".city-prev").each(function (i, e) {
      var cityId = e.dataset.cityId;
      var imgSrc = that.contentFolderUrl +"/maps-landing-parts/"+ cityId +"-lines-"+ dataType +".svg";
      $(e).find(".thumb-wrapper .lines").attr("src", imgSrc);
      console.log("----------", that)
      $(e).find(".texts .stat-text-home").text(that.state.data[cityId].stats[dataType].text);
      $(e).find(".texts .source").text(that.state.data[cityId].stats[dataType].source);
    });
    $(".switch [data-data-type]").removeClass("active");
    $(".switch [data-data-type='"+ dataType +"']").addClass("active");
    this.state.currentDataType = dataType;
  }

  this.toggleLegend = function () {
    $("#legend-overlay").toggleClass("show");
    $("#header").toggleClass("hide", $("#legend-overlay").hasClass("show"));
  }

  this.displayCityDetail = function () {
    $(".city-contents").addClass("reveal");
  }

  this.landing = function (isLanding) {
    if (isLanding) {

      window.scrollTo(0, 0);

      var size = getBootstrapSize();
      var nth = null, n = null;
      if (size == "xs") { nth = 1; n = 1; }
      if (size == "sm") { nth = 1; n = 2; }
      if (size == "md") { nth = 2; n = 3; }
      if (size == "lg") { nth = 2; n = 4; }
      if (size == "xl") { nth = 3; n = 5; }
      $(".city-prev").each(function (i, e) {
        if (i < n) {
          $(e).removeClass("off");
        }
      });

      if (size == "md" || size == "lg" || size == "xl") {
        var scale = 1.25;
        var h = $(window).height();
        var s = $(".city-prev").height() * scale;
        var headerH = $("section.all-cities").position().top;
        
        // --- translate .all-cities
        var translateY = (h - s) / 2 - headerH; // vert centered
        
        /*** COMPENSATE ***/ // translateY -= (30 + s*0.03);
        /*** COMPENSATE ***/ translateY -= 30;

        var transform = "scale("+ scale +") translateY("+ translateY +"px)";
        console.log("translateY", translateY)
        $("section.all-cities").css("transform", transform);

        // --- position title & comment
        $("#comment-landing .top").css("height", ((h - s)/2) +"px");
        $("#comment-landing .bottom").css("height", ((h - s)/2) +"px");
      }

      $(".city-prev:nth-child("+ nth +")").addClass("legend-on");
      $("#comment-landing").addClass("show");
      $("body").addClass("landing");

    } else {
    
      $("section.all-cities").css("transform", "scale(1) translateY(0)");
      $(".city-prev").removeClass("off").removeClass("legend-on");
      $("#comment-landing").removeClass("show");
      $("body").removeClass("landing");
    }
    this.state.landing = isLanding;
  }
}

$(document).ready(function () {
  
  // -------------------------------
  // BEGIN
  // -------------------------------

  a = new App(baseUrl, contentFolderUrl, formattedDataset, palette); 
  if (cityData) {
    a.landing(false);
    a.fillDataLines(cityData);
    a.uniformDescriptionHeights();
    a.displayCityDetail();
  } else {
    a.landing(true);
  }

  // -------------------------------
  // EVENTS
  // -------------------------------

  $("[data-url]").click(function () {
    document.location = this.dataset.url;
  });

  // $(window).scroll(_.throttle(function() {
  $(window).scroll(function() {
    var scroll = $(window).scrollTop();
    
    // ---  Handle header classes

    var scrolledUp = scroll < (a.state.scrollPos - 5);
    var scrolledDown = scroll > a.state.scrollPos;
    var headerIsVisible = !$("#header").hasClass("hide");
    if (headerIsVisible && scrolledDown) {
      $("#header").addClass("hide");
    }
    if (!headerIsVisible && (scrolledUp || scroll == 0)) {
      $("#header").removeClass("hide");
    }

    // ---  Handle landing screen

    var landingTextBottom = $("#comment-landing").position().top + $("#comment-landing").height();
    var landingTextInViewport = (landingTextBottom - scroll) < $(window).height();
    if (a.state.landing && scrolledDown && scroll > 50 && landingTextInViewport) {
      a.landing(false);
    }

    a.state.scrollPos = scroll;
  });


});

// -------------------------------
// FUNCTIONS
// -------------------------------


// --- 
function getBootstrapSize () {
  var w = $(window).width();
  if (w < 576) { return "xs"; }
  else if (w < 768) { return "sm"; }
  else if (w < 992) { return "md"; }
  else if (w < 1200) { return "lg"; }
  else { return "xl"; }
}


// --- Shuffle items
// --- via https://css-tricks.com/snippets/jquery/shuffle-dom-elements/

(function($){
  $.fn.shuffle = function() {
    var allElems = this.get();
    var getRandom = function(max) {
      return Math.floor(Math.random() * max);
    };
    var shuffled = $.map(allElems, function(){
      var random = getRandom(allElems.length);
      var randEl = $(allElems[random]).clone(true)[0];
      allElems.splice(random, 1);
      return randEl;
    });

    console.log(shuffled)

    this.each(function(i){
      $(this).replaceWith($(shuffled[i]));
    });
    return $(shuffled);
  };
})(jQuery);

