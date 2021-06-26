 <div class="admin-nav p-0" id="side-nav-wrapper">
     <div class="list-group list-group-flush accordion" id="accordion">
         <nav class="py-2">
             <ul class="navbar-nav menu1">
                 <li class="nav-item" id="profile">
                     <a href="<?=PROOT?>members/index" class="text-light list-group-item admin-link"><i
                             class="fas fa-user-friends"></i>&nbsp;&nbsp;Profile</a>
                 </li>
                 <li class="nav-item" id="feedback">
                     <a href="<?=PROOT?>members/feedback" class="text-light list-group-item admin-link"><i
                             class="fas fa-comment"></i>&nbsp;&nbsp;Feedback</a>
                 </li>

                 <li class="nav-item" id="notification">
                     <a href="<?=PROOT?>members/notification"
                         class="list-group-item text-light admin-link <?= $_SERVER['REQUEST_URI']  == PROOT . 'admin' . DS .'adminnotification'?"nav-active":""; ?> "><i
                             class="fas fa-bell"></i>&nbsp;&nbsp;Notification&nbsp;<span
                             id="checkNotification"></span></a>
                 </li>
                 <li class="nav-item" id="posts">
                     <a href="#" class="list-group-item text-light admin-link" data-toggle="collapse"
                         data-target="#UserPosts" aria-expanded="true" aria-controls="UserPosts"><i
                             class="fas fa-sticky-note"></i>&nbsp;&nbsp;Posts</a>
                     <ul class="collapse navbar-collapse menu2" id="UserPosts" aria-labelledby="headingOne"
                         data-parent="#accordion">
                         <li class="nav-item list-group"> <a href="<?=PROOT?>members/posts"
                                 class="nav-link text-secondary"><i class="far fa-newspaper fa-lg"></i>&nbsp;&nbsp;All
                                 Post</a> </li>
                         <li class="nav-item list-group"> <a href="<?=PROOT?>members/categories"
                                 class="nav-link text-secondary"><i class="fas fa-tags fa-lg"></i>&nbsp;&nbsp;All
                                 Catégories
                             </a> </li>
                     </ul>
                 </li>
                 <li class="nav-item" id="association">
                     <a href="#" class="list-group-item text-light admin-link" data-toggle="collapse"
                         data-target="#Userassoc" aria-expanded="true" aria-controls="Userassoc"><i
                             class="fas fa-industry"></i>&nbsp;&nbsp;Associations </a>
                     <ul class="collapse navbar-collapse menu2" id="Userassoc" aria-labelledby="headingOne"
                         data-parent="#accordion">
                         <li class="nav-item list-group"> <a href="<?=PROOT?>members/associations"
                                 class="nav-link text-secondary"><i class="far fa-newspaper fa-lg"></i>&nbsp;&nbsp;All
                                 association</a> </li>
                         <li class="nav-item list-group"> <a href="<?=PROOT?>members/mailling"
                                 class="nav-link text-secondary"><i class="fas fa-tags fa-lg"></i>&nbsp;&nbsp;Mailling
                                 to contact
                             </a> </li>
                     </ul>
                 </li>

             </ul>
         </nav>
     </div>
 </div>