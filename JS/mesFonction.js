var $numQuestion = 0;
function Effacer()
{
    let container = document.getElementById('container');
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }
    $numQuestion = 0;
}

function Verifier()
{
    var type = $('input:radio[name=choix]:checked').val();
    var uniqueReponse = $('input:radio[name=uniqueReponse]:checked').val();
    var MultipleReponse = $('input:radio[name=multipleReponse[]]:checked').val();



    if(typeof(type) == "undefined")
    {
        alert("Choissiez un type ")
    }
    
    
}
function AjouterQuestion()
{
    var choix = $('input:radio[name=choix]:checked').val();
    if(typeof(choix) == "undefined")
    {
        alert("Choissiez un type ")
    }
    else
    {
        $numQuestion = $numQuestion+1;
    
        if($('input:radio[name=choix]:checked').val()=="unique")
        {
            $('#container').append("<div><h5>Proposition "+$numQuestion+" </h5><input type='text' name='proposition[]' id=''><input onclick='RetirerQuestion($(this))' type='button'value='Supprimer'><input type='radio' name='uniqueReponse' id=''></div>");
        }
        else
        {
            $('#container').append("<div><h5>Proposition "+$numQuestion+" </h5><input type='text' name='proposition[]' id=''><input onclick='RetirerQuestion($(this))' type='button'value='Supprimer'><input type='checkbox' name='multipleReponse[]' id=''></div>");
        }
    }
   
   
    
    
    
}
function RetirerQuestion(input)
{
    input[0].parentElement.remove(); 
    
   
}