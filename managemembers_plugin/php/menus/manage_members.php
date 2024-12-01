<?php

function manage_members_template()
{
    global $wpdb;

    $query = "SELECT COUNT(id) FROM {$wpdb->prefix}members";
    $members = $wpdb->get_results($query, ARRAY_A);

    ?>

   <div class="manage-members-container" x-data="manageMembers">
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
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="manage-members-actions">
                 <button @click="toggleUpdateModal(),fillUpdateModalInputs('Erwin')">
                   Update
                </button>
                 <button>Delete</button>
                </td>

            </tr>
        </tbody>
    </table>
 
    <div class="manage-member-modal" x-show="openUpdateModal" >
     
     <form class="box-form" action="" @click.outside="toggleUpdateModal()">
     <h1>Update Member</h1>
        <div class="input-group">
           <label for="name">Name</label>
           <input id="name" type="text" name="name" value="" />
        </div>
        <div class="input-group">
           <label for="lastName">Last Name</label>
           <input id="lastName" type="text" name="lastName" value="" />
        </div>
        <div class="input-group">
           <label for="email">Email</label>
           <input id="email" type="email" name="email" value="" />
        </div>
        <div class="input-group">
           <label for="document">Document</label>
           <input id="document" type="number" name="document" value="" />
        </div>
        <div class="input-group">
           <label for="memberStatus">Member Status</label>
           <select name="memberStatus" id="memberStatus">
             <option value="">....</option>
             <option value="member">Member</option>
             <option value="trial">Trial</option>
           </select>
        </div>
        <button type="submit">Send</button>
     </form>
    </div>

    <div class="manage-member-modal" x-show="openAddModal" >
    
    <form class="box-form" action="" @click.outside="toggleAddModal()">
    <h1>Add Member</h1>
    <div class="input-group">
           <label for="name">Name</label>
           <input id="name" type="text" name="name" value="" />
        </div>
        <div class="input-group">
           <label for="lastName">Last Name</label>
           <input id="lastName" type="text" name="lastName" value="" />
        </div>
        <div class="input-group">
           <label for="email">Email</label>
           <input id="email" type="email" name="email" value="" />
        </div>
        <div class="input-group">
           <label for="document">Document</label>
           <input id="document" type="number" name="document" value="" />
        </div>
        <div class="input-group">
           <label for="memberStatus">Member Status</label>
           <select name="memberStatus" id="memberStatus">
             <option value="">....</option>
             <option value="member">Member</option>
             <option value="trial">Trial</option>
           </select>
        </div>
        <button type="submit">Send</button>
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
