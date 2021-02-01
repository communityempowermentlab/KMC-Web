/*=========================================================================================
  File Name: sitemap.js
  Description: external custom js file for sitemap module
==========================================================================================*/



$(document).ready(function(){
    setTimeout(function(){ $('#secc_msg').fadeOut(); }, 10000);

    $('.set_div_img2').on('click', function() {
        $('#secc_msg').fadeOut();
    });


    $(window).scroll(function() {
      $("#menuFormDiv").css({
        "margin-top": ($(window).scrollTop()) + "px",
        "margin-left": ($(window).scrollLeft()) + "px",
        "transition": "1s"
      });

      $("#addChildDiv").css({
        "margin-top": ($(window).scrollTop()) + "px",
        "margin-left": ($(window).scrollLeft()) + "px",
        "transition": "1s"
      });

      $("#editNodeDiv").css({
        "margin-top": ($(window).scrollTop()) + "px",
        "margin-left": ($(window).scrollLeft()) + "px",
        "transition": "1s"
      });

    });

    $('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var table = 'manageSitemap';
        var text = $(this).html();
        var txt = '';
        if (text == 'Deactive') {
            txt = 'Active';
        } else {
            txt = 'Deactive';
        }

        var msg  = 'Are you sure ' +txt+ ' this record';
        
        var conf = confirm(msg);
        var s_url = $(this).attr('s_url'); 
        if (conf) {
            $.ajax({
                data: {'table': table, 'id': s_id},
                url: s_url,
                type: 'post',
                success: function(data){ 
                    if (data == '1') {
                        $('#'+get_id).removeClass('btn-outline-warning');
                        $('#'+get_id).addClass('btn-outline-success');
                        $('#mid'+s_id).removeClass('btn-secondary');
                        $('#mid'+s_id).addClass('btn-primary');
                        $('#'+get_id).text('Active');
                    } else if (data == '2') {
                        $('#'+get_id).removeClass('btn-outline-success');
                        $('#'+get_id).addClass('btn-outline-warning');
                        $('#mid'+s_id).removeClass('btn-primary');
                        $('#mid'+s_id).addClass('btn-secondary');
                        $('#'+get_id).text('Deactive');
                    }
                }
            });
        }

    });

});


  function openHeadingMenuDiv()
    {
        $('#menuFormDiv').show();
        $('#addChildDiv').hide();
        $('#editNodeDiv').hide();
    }

    function checkMenuType(type)
    {
        if(type==1)
        {
            $('#m_name').html("Heading Name");
            $("#label_name").attr("placeholder", "Heading Name");
        }
        else
        {
            $('#m_name').html("Menu Name");
            $("#label_name").attr("placeholder", "Menu Name");
        }
    }

    function addNewChild(id, url)
    {
        
        $.ajax({
            url: url,
            type: 'post',
            data: {
                    'id': id
                },
            success: function(data) {
                $('#addChildDiv').show();
                $('#menuFormDiv').hide();
                $('#editNodeDiv').hide();
                $('#addChildDiv').html(data);
            }
        });
    }

    function editNode(id, url)
    {
        
        $.ajax({
            url: url,
            type: 'post',
            data: {
                    'id': id
                },
            success: function(data) {
                $('#addChildDiv').hide();
                $('#menuFormDiv').hide();
                $('#editNodeDiv').show();
                $('#editNodeDiv').html(data);
            }
        });
    }

    /*Update Menu Position*/
    function updateMenu(data, url) { 
        $.ajax({
            url: url,
            type:'post',
            data:{position:data},
            success:function(resp){ 
                // alert('menu changed');
            }
        });
    }

    // sortable function for heading and menu without heading 
    var currentlyScrolling = false;
    var SCROLL_AREA_HEIGHT = 40;

     $('#heading').sortable({ 
        scroll: true,
        sort: function(event, ui) {

          if (currentlyScrolling) {
            return;
          }

          var windowHeight   = $(window).height();
          var mouseYPosition = event.clientY;

          if (mouseYPosition < SCROLL_AREA_HEIGHT) {
            currentlyScrolling = true;

            $('html, body').animate({
              scrollTop: "-=" + windowHeight / 2 + "px" // Scroll up half of window height.
            }, 
            400, // 400ms animation.
            function() {
              currentlyScrolling = false;
            });

          } else if (mouseYPosition > (windowHeight - SCROLL_AREA_HEIGHT)) {

            currentlyScrolling = true;

            $('html, body').animate({
              scrollTop: "+=" + windowHeight / 2 + "px" // Scroll down half of window height.
            }, 
            400, // 400ms animation.
            function() {
              currentlyScrolling = false;
            });

          }
        },

        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('#heading>.heading_div').each(function() {
                selectedData.push($(this).attr("data-id"));
            }); 
            updateMenu(selectedData);
        }
    });


    function updateLabel(){
      var level_name = $('#level_name').val();
      if(level_name == ''){ 
        $('#err_level_name').text('This field is required.').show();
        return false;
      } else {
        $('#err_level_name').text('').hide();
      }
    }


    function validateNewChild(){
      var level_name = $('#level_name').val();
      if(level_name == ''){ 
        $('#err_level_name').text('This field is required.').show();
        return false;
      } else {
        $('#err_level_name').text('').hide();
      }
    }