<x-app-layout>
    <h2>Welcome Admin<h2>
        <style>
        
            /*tab styling*/
            body {font-family: Arial;}
            
            /* Style the tab */
            .tab {
              overflow: hidden;
              border: 1px solid #ccc;
              background-color: #f1f1f1;
            }
            
            /* Style the buttons inside the tab */
            .tab button {
              background-color: inherit;
              float: left;
              border: none;
              outline: none;
              cursor: pointer;
              padding: 14px 16px;
              transition: 0.3s;
              font-size: 17px;
              color:black;
            }
            
            /* Change background color of buttons on hover */
            .tab button:hover {
              background-color: #ddd;
            }
            
            /* Create an active/current tablink class */
            .tab button.active {
              background-color: #ccc;
            }
            
            /* Style the tab content */
            .tabcontent {
              display: none;
              padding: 6px 12px;
              
              border-top: none;
            }
        
            .notification {
        background-color: #555;
        color: white;
        text-decoration: none;
        padding: 15px 26px;
        position: relative;
        display: inline-block;
        border-radius: 2px;
        }
        
        .notification:hover {
        background: red;
        }
        
        .notification .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: red;
        color: white;
        margin-top: 10px;
        margin-right: 13px;
        }
            </style>    
        
        
        <div class="tab">
            <button class="tablinks  notification" onclick="openRequests(event, 'Student')">Student <span id="studnotification" class="badge"></span></button>
            <button class="tablinks  notification" onclick="openRequests(event, 'Teachers')">Teachers <span id="teachernotification" class="badge"></span></button>
           
          </div>
          
          <div id="Student" class="tabcontent">
            <h3>Student</h3>
            <table class="table table-bordered table-responsive-lg">
              <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>email</th>
                  <th>role</th>
                  <th>Assign Teacher</th>
                  
            
            <th style="column-span:2; ">Actions</th>
              </tr>
              
              @foreach ($student as $student2)
              <tr>
                  <td>{{$student2->id}}</td>
                  <td>{{$student2->name}}</td>
                  <td>{{$student2->email}}</td>
                  <td>{{$student2->role}}</td>
                  <td><select class="form-control" id="teacher{{$student2->id}}"  name="teacher{{$student2->id}}">

                    <option value="">Select Teacher</option>
                    @foreach ($allteacher as $allteacher2)
                    <option value="{{$allteacher2->id}}">{{$allteacher2->name}}</option>
                    @endforeach
                  </select>
                </td>

                 
                  <td><a type="button" class='btn btn-success'  onclick="studentapprovedata('{{$student2->id}}','teacher{{$student2->id}}')">Approve</a></td>
                  <td><a  class='btn btn-primary' href="<?php echo url('/adminstudedit')?>/{{$student2->id}}" >Edit</a></td>
          <td><a type="button" class='btn btn-danger'  onclick="studentdeletedata('{{$student2->id}}')" >delete</a></td>
          
                  
              </tr>
          @endforeach
          </table>
          
          </div>
          
          <div id="Teachers" class="tabcontent">
            <h3>Teachers</h3>
            <table class="table table-bordered table-responsive">
              <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>email</th>
                  <th>role</th>
                  
            <th>Actions</th>
              </tr>
              @foreach ($teacher as $teacher2)
              <tr>
                  <td>{{$teacher2->id}}</td>
                  <td>{{$teacher2->name}}</td>
                  <td>{{$teacher2->email}}</td>
                  <td>{{$teacher2->role}}</td>

                  <td><a type="button" class='btn btn-success'  onclick="teacherapprovedata('{{$teacher2->id}}','teacher{{$teacher2->id}}')">Approve</a></td>
                  <td><a  class='btn btn-primary' href="<?php echo url('/adminstudedit')?>/{{$teacher2->id}}" >Edit</a></td>
          <td><a type="button" class='btn btn-danger'  onclick="teacherdeletedata('{{$teacher2->id}}')" >delete</a></td>
          
                  
              </tr>
          @endforeach
              
             
          </table> 
         
          </div>
        
         
          <script>
            function openRequests(evt, recordtype) {
              var i, tabcontent, tablinks;
              tabcontent = document.getElementsByClassName("tabcontent");
              for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
              }
              tablinks = document.getElementsByClassName("tablinks");
              for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
              }
              document.getElementById(recordtype).style.display = "block";
              evt.currentTarget.className += " active";
            }
            </script>
        <!--teacher related script-->
          <script>
            function teacherapprovedata(id) {
            
        $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        
        type: "POST",
        url: "<?php echo url('/api/teacherapprove')?>/"+id,
        data: {id: id},
        
           success: function(result){
          
                  //console.log(result);
                if(result==1){
                    
                  alert("teacher approved Successfully");
                  window.location.reload(true);
                    }
                    else
                    {
                     
                      alert("teacher approval Failed");
                    }
        }
        
        })
        }
        
        
            </script>
         
        
        
         <!--student related script-->
          <script>
              function studentapprovedata(id,teacher) {
                var assignedteacher=  $('#'+teacher).val();
                var token=
               // alert(assignedteacher);
        $.ajax({
          
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),'Access-Control-Allow-Origin':'*' },
        
          type: "POST",
          url: "<?php echo url('/api/studapprove')?>/"+id,
          data: {
                  id: id, assignedteacher: assignedteacher},
        
             success: function(result){
            
                    //console.log(result);
                  if(result==1){
                      
                    alert("student approved Successfully");
                    window.location.reload(true);
                      }
                      else
                      {
                       
                        alert("student approval Failed");
                      }
         }
          
        })
        }
        
    
              </script>
</x-app-layout>
