function App (siteUrl, contentFolderUrl, data, palette) {
    console.log(palette)

  // construct

  this.state = {
    data: data,
    currentDataType: "population",
    scrollPos: null,
  };
  this.siteUrl = siteUrl;
  this.contentFolderUrl = contentFolderUrl;
  this.palette = palette;
  console.log(this.contentFolderUrl)
  
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
      largestDataLine.css("fill", "rgba(255,255,255,0.3)").prependTo(parent);
      // ------ Most external line
      // var largestDataLine = $(e).find("svg #line-30");
      // var parent = $(e).find("svg");
      // largestDataLine.css("fill", "rgba(255,255,255,0.3)").prependTo(parent);

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
  }

  this.displayCityDetail = function () {
    $(".city-contents").addClass("reveal");
  }
}

$(document).ready(function () {
  
  // -------------------------------
  // BEGIN
  // -------------------------------

  a = new App(baseUrl, contentFolderUrl, formattedDataset, palette); 
  if (cityData) {
    a.fillDataLines(cityData);
    a.uniformDescriptionHeights();
    a.displayCityDetail();
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
    console.log(scroll);
    
    // Handle header classes
    // ---------------------

    var scrolledUp = scroll < (a.state.scrollPos - 5);
    var scrolledDown = scroll > a.state.scrollPos;
    var headerIsVisible = !$("#header").hasClass("hide");
    if (headerIsVisible && scrolledDown) {
      $("#header").addClass("hide");
    }
    if (!headerIsVisible && (scrolledUp || scroll == 0)) {
      $("#header").removeClass("hide");
    }

    a.state.scrollPos = scroll;
  });


});

// -------------------------------
// FUNCTIONS
// -------------------------------

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

