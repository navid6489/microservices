<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"></a>
          </div>
      <ul class="nav navbar-nav navbar-right"style="margin-right:10px">
        
        
        <li style=" margin-top:5px"> 
          <div class="dropdown">
            <a class=" dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-bell" style="font-size:24px; color:white"></i>
            </a>
            <ul class="dropdown-menu">
             
              @foreach (Auth::user()->unreadNotifications as $unreadnotifications)
              <li><a href="#">{{$unreadnotifications->data['data']}}</a></li>
              
              
              @endforeach
              
            </ul>
          </div>
        
           
          </li>

          <li style="padding-left:30px; margin-top:2px"> 
            <form method="POST" action="{{ route('logout') }}">
                        @csrf
    
                        <input type="submit" class="btn btn-danger mt-2" name="submit" id="submit" value="logout">
                    </form>
             
            </li>
        </div>
          
      </ul>
    </div>
  </nav>