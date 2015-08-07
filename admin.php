<?php only_admin_access() ?>
<?php

$settings = get_option('settings', $params['id']);

$defaults = array(
    'name' => '',
    'url' => '',
    'file' => ''
);

$json = json_decode($settings, true);

if (isset($json) == false or count($json) == 0) {
    $json = array(0 => $defaults);
}

  ?>

<input type="hidden" class="mw_option_field" name="settings" id="settingsfield" />
<a class="mw-ui-btn" href="javascript:services.create()">Add new</a>
<div id="service-settings">
  <?php
$count = 0;
    foreach($json as $slide){
       $count++;
    

    ?>
  <div class="mw-ui-box  service-setting-item" id="service-setting-item-<?php print $count; ?>">
    <div class="mw-ui-box-header"> <a class="pull-right" href="javascript:services.remove('#service-setting-item-<?php print $count; ?>');">x</a></div>
    <div class="mw-ui-box-content mw-accordion-content">
      <div class="mw-ui-row-nodrop">
        <div class="mw-ui-col">
          <div class="mw-ui-col-container">
            <label class="mw-ui-label">Name</label>
            <input type="text" class="mw-ui-field service-name w100 " value="<?php print $slide['name']; ?>" >
          </div>
        </div>
        <div class="mw-ui-col">
          <div class="mw-ui-col-container">
            <label class="mw-ui-label">URl</label>
            <input type="text" class="mw-ui-field service-url w100" value="<?php print $slide['url']; ?>">
          </div>
        </div>
      </div>
      <div class="mw-ui-field-holder">
        <label class="mw-ui-label">File</label>
        <input type="hidden" class="mw-ui-field service-file" value="<?php print $slide['file']; ?>">
        <span class="mw-ui-btn service-file-up"> <span class="ico iupload"></span> <span>Upload file </span> </span> </div>
    </div>
  </div>
  <?php } ?>
</div>
<script>
    
    services = {
		    init:function(item){
            	$(item.querySelectorAll('input[type="text"]')).bind('keyup', function(){
                    mw.on.stopWriting(this, function(){
                        services.save();
                    });
                });
                var up = mw.uploader({
                  filetypes:'*',
                  element:item.querySelector('.service-file-up')
                });
                $(up).bind('FileUploaded', function(event, data){
					item.querySelector('.service-file').value = data.src
                    services.save();
                });
        },
		
        collect : function(){
            var data = {}, all = mwd.querySelectorAll('#service-settings .service-setting-item'), l = all.length, i = 0;
            for( ; i < l ; i++){
                var item = all[i];
                data[i] = {};
                data[i]['name'] = item.querySelector('.service-name').value;
                data[i]['url'] = item.querySelector('.service-url').value;
                data[i]['file'] = item.querySelector('.service-file').value;
               
            }
            return data;
        },
        save: function(){
            mw.$('#settingsfield').val(JSON.stringify(services.collect())).trigger('change');
        },
		
		
		  create:function(){
            var last = $('.service-setting-item:last');
            var html = last.html();
            var item = mwd.createElement('div');
            item.className = last.attr("class");
            item.innerHTML = html;
            $(item.querySelectorAll('input')).val('');
            $(item.querySelectorAll('.mw-uploader')).remove();
            last.after(item);
            services.init(item);
        },

		remove: function(element){
			var txt;
			var r = confirm("Are you sure?");
			if (r == true) {
				$(element).remove();
				services.save();
			}    
		},



	}
	
	
	 
	
	   $( document ).ready(function() {
         var all = mwd.querySelectorAll('#service-settings .service-setting-item'), l = all.length, i = 0;
            for( ; i < l ; i++){
                if(!!all[i].prepared) continue;
                var item = all[i];
                item.prepared = true;
                services.init(item);
            }
        });

 
</script>