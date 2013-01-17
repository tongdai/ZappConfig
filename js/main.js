$(function(){  

    //TOOLTIP//
    $(".question_sign").tooltip();

    //FORM SUBMISSION//
    $('#submit_app').click(function(){
        
        $(this).html('<i class="icon-refresh icon-spin"></i> Submitting...');
        
        var formData = new FormData($('form')[0]); 

        $('input:file').each(function(){
            var value = $(this).val();
            var array = value.split('\\');
            var last =  array.pop();
            formData.append( $(this).attr('id'), last);
        });

        $.ajax({
            url: 'php/mail.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                $('#submit_app').html('<i class="icon-ok"></i> Sent').attr('disabled', 'disabled'); 
                $('#submitAlert').text('We will respnd to your submission as soon as possible.') 
            }
        });
    });
    //APP SUBMISSION//
    $('form').change(function(){
        var count = 0;
        $('form input').each(function(){            
            if($(this).hasClass('required') && !$(this).hasClass('valid') && $(this).val() == '' || $(this).hasClass('text_required') && $(this).val() == ''){
                count++;
            }
        });
        if(count>0){
            $('#submit_app').removeClass('btn-primary').removeClass('btn-success').addClass('btn-danger').attr('disabled', 'disabled').html('Please Finish Form');
            $('#submitAlert').text('Please complete all required fields before submitting form.')
        }else{
            $('#submit_app').removeClass('btn-primary').removeClass('btn-danger').addClass('btn-success').removeAttr('disabled','disabled').html('Finish and Submit');
            $('#submitAlert').html('');
        };
    });

    //INPUT VALIDATION LIBRARY//
    $('.text_required').change(function(){
        var value = $(this).val();
        var msg = 'Required Field';
        if(value == ''){
            $(this).removeClass('valid').addClass('invalid').tooltip({title : msg});
        }else{
            $(this).removeClass('invalid').addClass('valid').tooltip('destroy');
        }
    })

    $('.email').change(function(){
        var value = $(this).val();
        var RegEx = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var msg = 'Please provide a proper email address';
        validateInput(this,value,msg,RegEx); 
    });
    $('.color').change(function(){
        var value = $(this).val();
        var RegEx = /^#[a-f0-9]{6}$/i;
        var msg = 'Please provide a proper 6 digit hexadecimal color';
        validateInput(this,value,msg,RegEx);    
    });
    $('.twitter').change(function(){
        var value = $(this).val();
        var RegEx = /@(.*)/;
        var msg = 'Please provide a proper twitter handle or hashtag';
        validateInput(this,value,msg,RegEx);
    });
    $('.url').change(function(){
        var value = $(this).val();
        var RegEx = /(ftp|http|https):\/\/([_a-z\d\-]+(\.[_a-z\d\-]+)+)(([_a-z\d\-\\\.\/]+[_a-z\d\-\\\/])+)*/;
        var msg = 'Please provide a proper URL';
        validateInput(this,value,msg,RegEx);
    })
    $('.image').change(function(){
        var value = $(this).val();
        var regEx = /\.(gif|jpg|jpeg|tiff|png)$/i;
        var msg = 'Please provide a proper image extension (.jpg, .png, etc.)';
        validateInput(this,value,msg,regEx);
    });

    //TAB TO TAB ERROR HANDLING//
    $(".nav-tabs a, .page_next, .page_previous").click(function(e) { 
        e.preventDefault(); 
        var count = 0;  
        var $tabs = $('#myTab li');    
        $('.tab-pane.active input').each(function(){            
            if($(this).hasClass('required') && !$(this).hasClass('valid') && $(this).val() == '' || $(this).hasClass('text_required') && $(this).val() == ''){
                count++;
                $(this).tooltip({title : 'Required Field'}).addClass('invalid');
            }else if($(this).hasClass('invalid')){
                count++;
            }
        });
        if(count>0){   
            $('.nav-tabs .active #warning-span').html('<i class="icon-warning-sign"></i>');
            $('.nav-tabs .active a').removeClass('alert-success').addClass('alert-error');
            var plural =  count>1?" fields":" field";  
            $('.tab-pane.active #alert').addClass('alert alert-error').text("Please fill out the page correctly before proceeding. You have " + count + plural + " left on the page.");
            if($(this).hasClass('page_next')){
                $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
                window.scrollTo(0, 0);
                return;
            }else if($(this).hasClass('page_previous')){
                $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
                window.scrollTo(0, 0);
                return;
            };      
        }else if(count == 0){ 
            $('.nav-tabs .active #warning-span').html('<i class="icon-ok-sign"></i>');
            $('.nav-tabs .active a').removeClass('alert-error').addClass('alert-success');  
            $('.tab-pane.active #alert').removeClass('alert alert-error').html(''); 
            if($(this).hasClass('page_next')){
                $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
                window.scrollTo(0, 0);
                return;
            }else if($(this).hasClass('page_previous')){
                $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
                window.scrollTo(0, 0);
                return;
            };      
        };

    });

    // Toggle for optional modules
    $('#id_viewer_navigation').change(function () {                
        $('#viewer_share').toggle(this.checked);
    }).change();
    $('#id_navigation_module').change(function () { 
        $('#id_navigation_module_options').toggle(this.checked);
        $('#id_navigation_module_title').toggleClass('text_required').removeClass('invalid').removeClass('valid');      
    }).change();
     $('#id_featured_carousel').change(function () { 
        $('#id_featured_carousel_options').toggle(this.checked);
        $('#id_featured_publications_publication_title_color').toggleClass('required').removeClass('invalid').removeClass('valid');
        $('#id_featured_publications_arrow_color').toggleClass('required').removeClass('invalid').removeClass('valid');
    }).change();
    $('#id_featured_publications_carousel_header').change(function () { 
        $('#id_featured_publications_carousel_header_options').toggle(this.checked);
        $('#id_featured_publications_carousel_header_font').toggleClass('text_required').removeClass('invalid').removeClass('valid');
        $('#id_featured_publications_carousel_header_color').toggleClass('required').removeClass('invalid').removeClass('valid');
    }).change();
     $('#id_featured_publications_navigation_bar').change(function () { 
        $('#id_featured_publications_navigation_bar_options').toggle(this.checked);
    }).change();
    $('#id_library_navigation_bar').change(function () { 
        $('#id_library_navigation_bar_options').toggle(this.checked);
    }).change();
    $('#id_youtube').change(function () { 
        $('#id_youtube_options').toggle(this.checked);
        $('#id_youtube_url').toggleClass('required').removeClass('invalid').removeClass('valid');
    }).change();
     $('#id_twitter').change(function () { 
        $('#id_twitter_options').toggle(this.checked);
        $('#id_twitter_account').toggleClass('required').removeClass('invalid').removeClass('valid');
    }).change();
});

//validateInput()
// Accepts the input,the value of the input, an error message, and a regular expression. 
function validateInput(input,value,msg,regEx){
    if(!regEx.test(value) && $(input).val()!=''){  
        $(input).removeClass('valid').addClass('invalid').tooltip({title : msg});               
    }else if(regEx.test(value) && $(input).val()!=''){   
        $(input).removeClass('invalid').addClass('valid').tooltip('destroy');            
    }else{
        $(input).removeClass('valid invalid').tooltip('destroy');
    }; 
};

