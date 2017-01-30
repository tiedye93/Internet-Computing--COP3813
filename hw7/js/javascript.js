<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34731274-1']);
    _gaq.push(['_trackPageview']);
    _gaq.push(['_trackEvent', 'sharing', 'viewed full-screen', 'snippet yPR4e',0,true]);
    (function() 
    {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        
    })();
    
    (function($) 
    { 
        $('#theme_chooser').change(function()
            {
                whichCSS = $(this).val();
                document.getElementById('snippet-preview').contentWindow.changeCSS(whichCSS);
            });
    })(jQuery);

    function passwordCheck()
    {
        var password = document.getElementById("password").innerHTML;
        var password1 = document.getElementById("password1").innerHTML;
                
                
        if(password1 == password)
        {
            return true;
        }
        else
        {
            alert("Passwords Do Not Match.");
                    
            return false;
                    
        }
    }
</script>