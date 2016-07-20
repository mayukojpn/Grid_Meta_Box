jQuery(function($) {

  $( "#normal-sortables" )
    .append( $( "<div class='gutter-sizer'></div>" ).css({"width": "2%"}) )
    .append( $( "<div class='box-sizer'></div>" ).css({"width": "32%", "min-width": "205px"}) );
  $( "#normal-sortables > .postbox" )
    .css({
      "width": "32%",
      "box-sizing": "border-box",
      "min-width": "205px",
      "float": "left"
    });

    var postbox = $( "#normal-sortables > .postbox" ),
        postbox_container = $( "#normal-sortables" ),
        options = {attributes: true, attributeFilter: ["class"]},
        mo = new MutationObserver(grid_meta_box_run);

        for(var i=0;i<postbox.length;i++){
          mo.observe(postbox[i], options);
        }

  function grid_meta_box_run ()
  {
    $('#normal-sortables').masonry({
      itemSelector: '.postbox',
      percentPosition: true,
      columnWidth: '.box-sizer',
      gutter: '.gutter-sizer'
    });
  }

  $(document).ready( grid_meta_box_run() );

});
