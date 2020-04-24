jQuery( document ).ready(function() {

  tinymce.create("tinymce.plugins.video_tinymce_button_js", {

          init : function(ed, url) {

              phpObj = JSON.parse(tinymce_btn_plugin.videos);

              phpObjSize = (phpObj.length) - 1 ;

              videos = [];

              for(var i in phpObj){

                   videos.push({text: phpObj[i].post_title,value: phpObj[i].ID });
              }

              ed.addButton("video_tinymce_button", {
                   cmd : "command_one",
                   icon  : 'icon dashicons-before dashicons-video-alt'
              });

              ed.addCommand("command_one", function() {
                      ed.windowManager.open({
                          title: 'Pick video post and choose the video frame border colour',
                          body: [
                                  {
                                      type: 'listbox',
                                      name : 'selectVideo',
                                      label: 'choose a video post',
                                      values : videos,

                                  },
                                  {
                                      type: 'colorpicker',
                                      name: 'color',
                                      label: 'choose border\'s colour',
                                  }
                          ],

                          onsubmit: function( e ) {
                              ed.insertContent( '[prefix_video id="' + e.data.selectVideo + '" border_color="' + e.data.color + '"]');
                          }
                      });

              });

          },


   });

   tinymce.PluginManager.add("video_tinymce_button_js", tinymce.plugins.video_tinymce_button_js);

});
