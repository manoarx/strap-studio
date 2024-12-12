jQuery(document).ready(function () {
  var intFrameHeight = window.innerHeight;
  $(".hFs").css("height", intFrameHeight);
  $(".hFsm").css("min-height", intFrameHeight);
  $(".hFsm2").css("min-height", (intFrameHeight / 4) * 3);

  window.addEventListener("resize", function (event) {
    var intFrameHeight = window.innerHeight;
    $(".hFs").css("height", intFrameHeight);
    $(".hFsm").css("min-height", intFrameHeight);
    $(".hFsm2").css("min-height", (intFrameHeight / 4) * 3);
  });

  var z ="#scrL01";
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 40) {
      $("body").addClass("scrollinG");
    } else {
      $("body").removeClass("scrollinG");
    }

    if (scroll >= 200) {
      $("body").addClass("scrollinG_z");
    } else {
      $("body").removeClass("scrollinG_z");
    }

    if (scroll >= 200) {
      $("body").addClass("rMvHd");
    } else {
      $("body").removeClass("rMvHd");
    }

  });

  $(document).on("click", "#mobHam", function () {
    $("body").toggleClass("mobShow");
  }); 
  
  $(document).on("click", ".dash_wrpRMenu_icon", function () {
    $("body").toggleClass("dash_menu_show");
  });
 $(document).on("click", ".dash_baKgrey", function () {
    $("body").removeClass("dash_menu_show");
  });


  $(document).on("click", ".dash_user_wrpRMenu", function () {
    $("body").toggleClass("dash_user_menu_show");
  });
 $(document).on("click", ".dash_user_baKgrey", function () {
    $("body").removeClass("dash_user_menu_show");
  });




  $(document).on("click", ".theBookIng", function () {
    $("#bookingModal").modal("show");
  });

  $(document).on("click", ".more_btn", function () {
    $("#collapseService").toggleClass("show_more");
  });

  $(document).on("click", ".lMnu", function (event) {
    console.log(event);
    console.log(event.target.className);
    if (event.target.className == "lMnu") {
      $("body").removeClass("mobShow");
    }
  });


 
  butter.init({
    wrapperId: "pG_Body",
    cancelOnTouch: true,
    wrapperDamper: 0.06,
  });
 
  $("#navbarMenu .dropdown,#languageMenu .dropdown,#accountMenu .dropdown").hover(function () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    } else {
      $(".dropdown-menu").stop(false, false).slideUp();
      if (!$(".dropdown-toggle", this).hasClass("show")) {
        const dropdownToggleEl = $(".dropdown-toggle", this);
        const dropdownList = new bootstrap.Dropdown(dropdownToggleEl);
        dropdownList.show();
      }
    }
  }); 
  
 

  $("#navbarMenu .dropdown,#languageMenu .dropdown, #accountMenu .dropdown").click(function (e) {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    } else {
      $(".dropdown-menu").stop(false, false).slideUp();
      if (!$(".dropdown-toggle", this).hasClass("show")) {
        const dropdownToggleEl = $(".dropdown-toggle", this);
        const dropdownList = new bootstrap.Dropdown(dropdownToggleEl);
        dropdownList.show();
      }
    }
  });

 

  
  $("#navbarMenu .dropdown").on("show.bs.dropdown", function () {
    $(this).find(".dropdown-menu").first().stop(false, false).slideDown();
    $("body").addClass("mnu");
  });
  $("#navbarMenu .dropdown").on("hide.bs.dropdown", function () {
    $(this).find(".dropdown-menu").first().stop(false, false).slideUp();
    $("body").removeClass("mnu");
  });

  $(".aftrHover").hover(function () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {} else {
      const dropdownToggleEl = $(".dropdown-toggle.show");
      const dropdownList = new bootstrap.Dropdown(dropdownToggleEl);
      dropdownList.hide(); 
    }
  });

  $(".aftrHover").click(function () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    } else {
      const dropdownToggleEl = $(".dropdown-toggle.show");
      const dropdownList = new bootstrap.Dropdown(dropdownToggleEl);
      dropdownList.hide(); 
    }
  });


  jQuery(".dropdown-menu.keep-open").on("click", function (e) {
    console.log("D");
    e.stopPropagation();
  });


  jQuery(".up_lD_bTnClk").on("click", function (e) {
    //$(this).parent().find("input").click();
    $("#myFileUpld").click();
  });


  $(document).on("change", "#myFileUpld", function () {
    var curt_itm =$(this).parent();
    for (var i = 0; i < this.files.length; i++) {
      var file = this.files[i];
      readAndPreview(file,curt_itm);
    }
  });


  function readAndPreview(file,curt_itm) {
    var reader = new FileReader();
    reader.addEventListener(
      "load",
      function () {
        console.log( file.result);
      //  $("#to_profile_pic_Img").attr("src",file.result);
        document.getElementById("to_profile_pic_Img").src =  this.result;

        $(".frm_to_Upload_txt",curt_itm).find("h6").remove();
        $(".frm_to_Upload_txt",curt_itm).append(
          "<h6> <span>" +
            file.name +
            '</span><span class="delete"><span>&times;</span></h6>'
        );
      },
      false
    );
    reader.readAsDataURL(file);
  }


  $(document).on("click", ".frm_to_Upload_txt .delete", function () {
   // $("#myFileUpld").val("");
    $(this).parent().find("input:file").val("");
    $(this).parent().remove();
  });


  $(document).on("click", ".snTWhts", function () {  
    let num = "+919495380335";
    let msg =  $('.forWhatsapp').val(); 
    var win = window.open(`https://wa.me/${num}?text=${msg}`, '_blank');
  });


  $(".gender_").select2({
    placeholder: "Choose",
    dropdownCssClass: "dropperDown",
  });
  $(".category_").select2({
    placeholder: "Category",
    dropdownCssClass: "dropperDown",
  });
  
  let startpicker = flatpickr(".pickUpDate", {
    enableTime: false,
    dateFormat: "D d M",
    onChange: function (selectedDates, dateStr, instance) {
    },
  });

  //document.addEventListener('contextmenu', event => event.preventDefault());
  /*document.addEventListener('contextmenu', (event)=>{
    console.log(event.target.id);
    event.preventDefault();
  });*/

});
