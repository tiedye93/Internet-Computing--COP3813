var report = function (meter, foot)
{
    document.getElementById("result").innerHTML = 
        meter + " m = " + foot + " f";
};

document.getElementById("f_to_m").onclick = function () 
{
    var f = document.getElementById("length").value;
    
    if(f < 0)
        {       
            document.getElementById("result").innerHTML = "Undefined--Negative Length";
        }
    
    else if(isNaN(f))
        {
           document.getElementById("result").innerHTML = "Undefined--Not a Number";
        }
    
    else
    {
        
        var convertF = (f / 3.28).toFixed(2);
        report(convertF , f); 
    }
    
};

document.getElementById("m_to_f").onclick = function () 
{
    var m = document.getElementById("length").value;
    
    if(m < 0)
        {       
            document.getElementById("result").innerHTML = "Undefined--Negative Length";
        }
    
    else if(isNaN(m))
        {
           document.getElementById("result").innerHTML = "Undefined--Not a Number";
        }
    
    else
    {
        var convertM = (m * 3.28).toFixed(2);
        report(m, convertM);
    }
    
};
    