

/*         var timer = 4000;

        var i = 0;
        var max = $('#the_Clients > li').length;




        $("#the_Clients > li").eq(i).addClass('active').css('left', '0');
        $("#the_Clients > li").eq(i + 1).addClass('active').css('left', '20%');
        $("#the_Clients > li").eq(i + 2).addClass('active').css('left', '40%');
        $("#the_Clients > li").eq(i + 3).addClass('active').css('left', '60%');
        $("#the_Clients > li").eq(i + 4).addClass('active').css('left', '80%');
    
    
        setInterval(function () {
    
          $("#the_Clients > li").removeClass('active');
          $("#the_Clients > li").eq(i).css('transition-delay', '0.25s');
          $("#the_Clients > li").eq(i + 1).css('transition-delay', '0.5s');
          $("#the_Clients > li").eq(i + 2).css('transition-delay', '0.75s');
          $("#the_Clients > li").eq(i + 3).css('transition-delay', '1s');
          $("#the_Clients > li").eq(i + 4).css('transition-delay', '1.1s');
    
          if (i < max - 5) {
            i = i + 5;
          } else {
            i = 0;
          }

          $("#the_Clients > li").eq(i).css('left', '0').addClass('active').css('transition-delay', '1.25s');
          $("#the_Clients > li").eq(i + 1).css('left', '20%').addClass('active').css('transition-delay', '1.5s');
          $("#the_Clients > li").eq(i + 2).css('left', '40%').addClass('active').css('transition-delay', '1.75s');
          $("#the_Clients > li").eq(i + 3).css('left', '60%').addClass('active').css('transition-delay', '2s');
          $("#the_Clients > li").eq(i + 4).css('left', '80%').addClass('active').css('transition-delay', '2.5s');

        }, timer);  */


// butter.js

(function(root){
    var FadeSlider = function() {

        var self = this;

        this.defaults = {
            wrapperId: 'fadeslider',
            items: 4,
            timer:3000,
            responsive:[],
        }
        
        this.validateOptions = function(ops) {
            for (var prop in ops) {
                if (self.defaults.hasOwnProperty(prop)) {
                    Object.defineProperty(self.defaults, prop, {value: Object.getOwnPropertyDescriptor(ops, prop).value})
                }
            }
        }

        this.wrapperId;
        this.wrapper;
        this.items;
        this.itemsUpd;
        this.timer;
        this.responsive;
        console.log("a");
    };

    FadeSlider.prototype = {

        init: function(options) {
            if (options) {
                this.validateOptions(options);
            }

            this.active = true;
            this.resizing = false;
            this.wrapperId = this.defaults.wrapperId;
            this.items = this.defaults.items;
            this.timer = this.defaults.timer;
            this.responsive = this.defaults.responsive;

            this.wrapper = document.getElementById(this.wrapperId);
           /*  this.wrapper.style.position = 'fixed'; */
             this.wrapper.style.width = '100%';

            this.wrapperHeight = this.wrapper.clientHeight;
            document.body.style.height = this.wrapperHeight + 'px';

            window.addEventListener('resize', this.resize.bind(this));
            if (this.cancelOnTouch) {
                window.addEventListener('touchstart', this.cancel.bind(this));
            }
         
            // window.addEventListener('load', this.resize.bind(this));
        console.log("b");

        this.toload();
        },

       

        checkResize: function() {
           // console.log("d");
            if (this.wrapperHeight != this.wrapper.clientHeight) {
                this.resize();
            }
        },
        toload: function(){
            var theSelf = this;
            var self = $(this.wrapper);
            var target = ('#'+this.wrapperId);
            var itemsS = this.items;
            this.itemsUpd = this.items;
            var timerS = this.timer;
            var responsiveS = this.responsive;

            var olY1 = true;
            for (let key in this.responsive) {
                if (this.responsive.hasOwnProperty(key)) {
                        console.log(`Key: ${key}, items: ${this.responsive[key].items}`); 
                    if( key > window.innerWidth && olY1){
                        this.itemsUpd = this.responsive[key].items;
                        olY1 = false;
                    }else{

                        console.log("else");
                    }

                }
            }

          /*   console.log(self);
            console.log(itemsS);
            console.log(timerS);
            console.log(target);
            console.log(responsiveS); */

            //var itemWidth = 100 / this.items;
            
           
            
            var itemWidth = 100 / this.itemsUpd;
            var itemsUpdAftr = this.itemsUpd;
            var target = ('#'+this.wrapperId);
            var max = $(target + ' > li').length;
            var i = 0;
        

            for (var j = 0; j < this.itemsUpd; j++) {
                $(target  + ' > li').eq(i + j).addClass('active').css('left', (itemWidth*j) + '%');
              }
              

            setInterval( function () {

            $(target+' > li').removeClass('active');
            
            for (var j = 0; j < itemsUpdAftr; j++) {
                $(target  + ' > li').eq(i + j).css('transition-delay', (.25*j) + 's');
              }
            
              if (i < max - itemsUpdAftr) {
              i = i + itemsUpdAftr;
            } else {
              i = 0;
            }
            for (var j = 0; j < itemsUpdAftr; j++) {
                $(target  + ' > li').eq(i + j).css('left', (itemWidth*j) + '%').addClass('active').css('transition-delay', (.25*this.items)+(.25*j) + 's');
              }

            }, this.timer); 

   
      

        },
        intrVlz : function(){

            var itemWidth = 100 / this.itemsUpd;
            var target = ('#'+this.wrapperId);
            var itemsUpdAftr = this.itemsUpd;

            var max = $(target + ' > li').length;
            var i = 0;

            $(target+' > li').removeClass('active');
            
            for (var j = 0; j < itemsUpdAftr; j++) {
                $(target  + ' > li').eq(i + j).css('transition-delay', (.25*j) + 's');
              }
            
              if (i < max - itemsUpdAftr) {
              i = i + itemsUpdAftr;
            } else {
              i = 0;
            }
            for (var j = 0; j < itemsUpdAftr; j++) {
                $(target  + ' > li').eq(i + j).css('left', (itemWidth*j) + '%').addClass('active').css('transition-delay', (.25*this.items)+(.25*j) + 's');
              }

                    console.log("loadZ");
          
    },
        resize: function() {
            var self = this;
            
            if (!self.resizing) {
                self.resizing = true;
                window.cancelAnimationFrame(self.animateId);
                window.setTimeout(function() {
                    self.wrapperHeight = self.wrapper.clientHeight;
                  /*   if (parseInt(document.body.style.height) != parseInt(self.wrapperHeight)) {
                        document.body.style.height = self.wrapperHeight + 'px';
                    } */
                   // self.animateId = window.requestAnimationFrame(self.animate.bind(self));
                    self.resizing = false;
                }, 150)

                var target = ('#'+this.wrapperId);
                $(target+' > li').removeClass('active');
                this.toload();

                
                console.log("f");
            }

        

        },

        animate: function() {
            //console.log("g");
            this.checkResize();
            this.wrapperUpdate();
            this.animateId = window.requestAnimationFrame(this.animate.bind(this));
        },

        cancel: function() {
            if (this.active) {
                window.cancelAnimationFrame(this.animateId);

                window.removeEventListener('resize', this.resize);
                window.removeEventListener('touchstart', this.cancel);
                this.wrapper.removeAttribute('style');
                document.body.removeAttribute('style');

                this.active = false;
                this.wrapper = "";
                this.wrapperOffset = 0;
                this.resizing = true;
                this.animateId = "";
            }
        },

    };

    root.fadeslider007 = new FadeSlider();
 

})(this);