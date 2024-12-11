<?php

function manage_members_template()
{

    ?>

<div class="manage-members-container" x-data="manageMembers" x-effect="getMembers()">
   <h1>Manage Members</h1>

  <div class="add-member-wrapper" @click="toggleAddModal()">
  Add Member<span class="dashicons dashicons-plus"></span>
  </div>

    <table class="manage-members-table" >
        <thead>
           <tr>
            <th>Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Document</th>
            <th>Member Status</th>
            <th>Created</th>
            <th>Actions</th>
           </tr>
        </thead>
        <tbody id="manageMembersTBody">

        </tbody>
    </table>

    <div id="manageMembersPagination" x-effect="renderPagination" >
     
     </div>

<!--  UPDATE FORM MODAL -->
    <div class="manage-member-modal" x-show="openUpdateModal" >

     <form class="box-form" action="" @click.outside="toggleUpdateModal()" @submit.prevent>
     <h1>Update Member</h1>
        <div class="input-group">
           <label for="name_update">Name</label>
           <input id="name_update" type="text" name="name" value="" />
        </div>
        <div class="input-group">
           <label for="lastName_update">Last Name</label>
           <input id="lastName_update" type="text" name="lastName" value="" />
        </div>
        <div class="input-group">
           <label for="email_update">Email</label>
           <input id="email_update" type="email" name="email" value="" />
        </div>
        <div class="input-group">
           <label for="document_update">Document</label>
           <input id="document_update" type="number" name="document" value="" />
        </div>
        <div class="input-group">
           <label for="memberStatus_update">Member Status</label>

           <select name="memberStatus_update" id="memberStatus_update">
             <option value="">....</option>
             <option value="member">Member</option>
             <option value="trial">Trial</option>
           </select>
        </div>
        <div id="sendButton">
        </div>

     </form>
    </div>
 
    <!-- ADD FORM MODAL -->
    <div class="manage-member-modal" x-show="openAddModal" >

    <form
          @click.outside="toggleAddModal()"
          @submit.prevent=""
          action=""
          class="box-form"
          id="addMemberForm"
          method="post"
    >
    <h1>Add Member</h1>
    <div class="input-group">
           <label for="name_add">Name</label>
           <input id="name_add" type="text" name="name" value="" />
        </div>
        <div class="input-group">
           <label for="lastName_add">Last Name</label>
           <input id="lastName_add" type="text" name="lastName" value="" />
        </div>
        <div class="input-group">
           <label for="email_add">Email</label>
           <input id="email_add" type="email" name="email" value="" />
        </div>
        <div class="input-group">
           <label for="document_add">Document</label>
           <input id="document_add" type="number" name="document" value="" />
        </div>
        <div class="input-group">
           <label for="memberStatus_add">Member Status</label>
           <select name="memberStatus_add" id="memberStatus_add">
             <option value="">....</option>
             <option value="member">Member</option>
             <option value="trial">Trial</option>
           </select>
        </div>

        <button type="submit" @click ="addNewMember">Send</button>
    </form>
   </div>

   </div>





<?php

}

function manage_members_menu()
{
    add_menu_page(
        __('Manage Member', bloginfo('name')),
        __('Manage Members', bloginfo('name')),
        'manage_options',
        'manage_members_page',
        'manage_members_template',
        'dashicons-admin-users',
        15
    );
}

add_action('admin_menu', 'manage_members_menu');
