<?php

$iconPrio = [];

$iconPrio[10] = '<i class="icon-flag min" title="min priority" ></i>';
$iconPrio[20] = '<i class="icon-flag low" title="low priority" ></i>';
$iconPrio[30] = '<i class="icon-flag avg" title="average priority" ></i>';
$iconPrio[40] = '<i class="icon-flag high" title="high priority" ></i>';
$iconPrio[50] = '<i class="icon-flag max" title="max priority" ></i>';

?>
<div id="wgt-grid-message-mini_list" class="wgt-grid" >
  <var id="wgt-grid-message-mini_list-cfg-grid" >{
    "height":"small",
    "search_form":""
  }</var>
  <table id="wgt-grid-message-mini_list-table" class="wgt-grid wcm wcm_widget_grid hide-head" >
    <thead>
      <tr>
        <th class="pos" >Pos:</th>
        <th style="width:150px;" >Title</th>
        <th style="width:120px;" >Sender</th>
        <th style="width:80px;" >Date</th>
        <th style="width:80px;" >Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $VAR->data as $entry ){

        $senderName = "{$entry['buiz_role_user_name']} <{$entry['core_person_lastname']}, {$entry['core_person_firstname']}> ";
        $date = '' != trim($entry['buiz_message_m_time_created'])
          ? $this->i18n->date($entry['buiz_message_m_time_created'])
          : ' ';
      ?>
      <tr>
        <td class="pos" ></td>
        <td><?php echo $entry['buiz_message_title']; ?></td>
        <td><?php echo $senderName; ?></td>
        <td><?php echo $date; ?></td>
        <td><?php

        echo $entry['task_id']
          ? '<i class="fa fa-tasks" title="Is Task" ></i> '
          : '';

        echo $entry['appoint_id']
          ? '<i class="fa fa-calendar" title="Is Appointment" ></i> '
          : '';


        // SPAM / HAM status
        ($entry['buiz_message_spam_level']>51)
        ? '<i class="fa fa-thumbs-down mal" title="is SPAM" ></i> '
            : '';

        // action required
        /*
        echo  ( 't' == $entry['receiver_action_required'])
        ? '<i class="fa fa-exclamation-sign attention" title="Your action is required" ></i> '
            : '';*/

        // urgent
        echo  ( 't' == $entry['flag_urgent'])
        ? '<i class="fa fa-time urgent" title="Ok, this getting a little urgent now!" ></i> '
            : '';

        // priority
        echo  ( $entry['buiz_message_priority'] && ($entry['buiz_message_priority'] > 30 || 10 == $entry['buiz_message_priority'] )  )
        ? $iconPrio[$entry['buiz_message_priority']].' '
            : ' ';
        ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>