<div class="contentArea" >

  <%=$this->includeAll('about')%>
  <div class="do-clear medium">&nbsp;</div>

</div>

<div class="do-clear medium">&nbsp;</div>

<script type="application/javascript">
<% foreach( $this->jsItems as $jsItem ){ %>
  <%=$ITEM->$jsItem->jsCode%>
<% } %>
</script>