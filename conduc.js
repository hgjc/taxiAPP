
function traerInfo(id){
   return new Promise(function(resolve,reject){
       $.ajax({
           url: 'data.php',
           type: 'POST',    
           data: {id: id},
               success:function(data){
                   resolve(data);
               },
               dataType:"json"
      });

   });

}

function elegido(){
    html="";
    let ele= document.getElementsByName('x');   
        for (i=0; i<ele.length;i++){
        if(ele[i].checked){
            aux=ele[i].value;
            traerInfo(aux).then(response => {
                document.getElementById('nombre').value=response[0];
                document.getElementById('apellido').value=response[1];
                document.getElementById('patente').value=response[2];
                document.getElementById('foto').innerHTML=response[3];
            });
            break;
        }else{
        }
            
        };  
    
};


