function addKeyFormDeleteLink($keyFormLi) {
    var $removeFormButton = $('<button type="button">Delete this key</button>');
    $keyFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $keyFormLi.remove();
    });
}

function addKeyForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a key" link li
    var $newFormLi = $('<div class="item_key"></div>').append(newForm);
    $newLinkLi.before($newFormLi);
    
}


$(function () {
    $(document).scroll(function () {
        var $nav = $("#mainNav");
        var section2 = $("#section2");
        var section3 = $("#section3");
        var section4 = $("#section4");
        var navTrigger2 = $(".section2");
        var navTriggerHeight2 = navTrigger2.height();
        $nav.toggleClass('scrolled', $(this).scrollTop() > (navTriggerHeight2 * 120) / 100);
        section2.toggleClass('btnNavActive', $(this).scrollTop() > (navTriggerHeight2 * 120) / 100 && $(this).scrollTop() < (navTriggerHeight2*260) / 100);
        section3.toggleClass('btnNavActive', $(this).scrollTop() > (navTriggerHeight2 * 260) / 100 && $(this).scrollTop() < (navTriggerHeight2*290) / 100);
        section4.toggleClass('btnNavActive', $(this).scrollTop() > (navTriggerHeight2 * 290) / 100);

        $('#topSection').scrollTop(0);
    });

    $('#username').hover(function() {
        $('.item1').toggle();
    });
   
    //Add keys dynamics
    var $collectionHolder;

    // setup an "add a tag" link
    var $addKeyButton = $('<button type="button" class="add_key_link">Ajouter une clé</button>');
    var $newLinkLi = $('<div></div>').append($addKeyButton);

    // Get the ul that holds the collection of keys
    $collectionHolder = $('#car_keys');

    // add the "add a tag" anchor and li to the keys ul
    $collectionHolder.append($newLinkLi);

    $collectionHolder.find('div[id^=car_keys]').each(function() {
        addKeyFormDeleteLink($(this));
    });

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addKeyButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addKeyForm($collectionHolder, $newLinkLi);
    });

    //Datatable
    
    $('#tableAdmin').DataTable( {
        responsive: true
    } );
    
    //uploadfile
    
    var container = $('#upload_file'), inputFile = $('#car_car_url'), img, btn, txt = 'Choisir', txtAfter = 'Parcourir une autre photo';
            
    if(!container.find('#upload').length){
        container.find('.input_upload').append('<input type="button" value="'+txt+'" id="upload">');
        btn = $('#upload');
        container.prepend('<img src="" class="hidden" alt="Uploaded file" id="uploadImg" width="100">');
        img = $('#uploadImg');
    }
            
    btn.on('click', function(){
        img.animate({opacity: 0}, 300);
        inputFile.click();
    });

    inputFile.on('change', function(e){
        container.find('label').html( inputFile.val() );
        
        var i = 0;
        for(i; i < e.originalEvent.srcElement.files.length; i++) {
            var file = e.originalEvent.srcElement.files[i], 
                reader = new FileReader();

            reader.onloadend = function(){
                img.attr('src', reader.result).animate({opacity: 1}, 700);
            }
            reader.readAsDataURL(file);
            img.removeClass('hidden');
        }
        
        btn.val( txtAfter );
    });
   
    

});



