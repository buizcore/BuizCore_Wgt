
<script id="tpl-buiz-form-designer-base" type="text/x-handlebars-template" >
<section id="wgt-box-buiz-form-designer-pos-{{pos}}" class="wgt-content_box form pad tpl-box">
    
  <nav>
    <button class="wgac-sub-edit wgt-button icon-only" ><i class="fa fa-edit"></i></button>
    <button class="wgac-sub-clone wgt-button icon-only" ><i class="fa fa-code-fork"></i></button>
    <button class="wgac-sub-delete wgt-button icon-only" ><i class="fa fa-trash"></i></button>
  </nav>

  <div class="editor content">
    <div class="left n-cols-2">

      <div class="wgt-box input" id="wgt-box-buiz-form-designer-name-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-name-pos-{{pos}}">Title</label>
        </div>
        <div class="wgt-input">
          <input 
            type="text" 
            value="{{title}}" 
            name="pos[{{pos}}][title]"
            class="f-title {{formid}}" 
            id="wgt-inp-buiz-form-designer-name-pos-{{pos}}" >
        </div>
        <div class="do-clear tiny"></div>
      </div>

      <div class="wgt-box input" id="wgt-box-buiz-form-designer-helptext-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-helptext-pos-{{pos}}">Hilfetext</label>
        </div>
        <div class="wgt-input">
          <textarea 
            type="text" 
            name="pos[{{pos}}][helptext]"
            class="f-help {{formid}}" 
            id="wgt-inp-buiz-form-designer-name-pos-{{pos}}" >{{helptext}}</textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>

      <div class="wgt-box input" id="wgt-box-buiz-form-designer-required-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-required-pos-{{pos}}">Pflichtfrage</label>
        </div>
        <div class="wgt-input">
          <input 
            type="checkbox" 
            name="pos[{{pos}}][helptext]"
            class="f-required {{formid}}" 
            {{#if required}} checked="checked" {{/if}}
            id="wgt-inp-buiz-form-designer-required-pos-{{pos}}" />
        </div>
        <div class="do-clear tiny"></div>
      </div>

      <div class="wgt-box input" id="wgt-box-buiz-form-designer-type-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-type-pos-{{pos}}">Typen</label>
        </div>
        <div class="wgt-input">
          <select class="type-changer" >
            <option {{#if type.text}} selected="selected" {{/if}} value="text" >Textfeld</option>
            <option {{#if type.textarea}} selected="selected" {{/if}} value="textarea"  >Freitext</option>
            <option {{#if type.checkboxes}} selected="selected" {{/if}} value="checkboxes"  >Checkboxes</option>
            <option {{#if type.radios}} selected="selected" {{/if}} value="radios"  >Radioboxes</option>
            <option {{#if type.range}} selected="selected" {{/if}} value="range"  >Range</option>
            <option {{#if type.money}} selected="selected" {{/if}} value="money"  >Money</option>
            <option {{#if type.matrix}} selected="selected" {{/if}} value="matrix"  >Matrix</option>
            <option {{#if type.list}} selected="selected" {{/if}} value="list"  >Liste</option>
            <option {{#if type.file}} selected="selected" {{/if}} value="file"  >Datei / Dokument</option>
            <option {{#if type.image}} selected="selected" {{/if}} value="image"  >Bild</option>
            <option {{#if type.photo}} selected="selected" {{/if}} value="photo"  >Photo</option>
            <option {{#if type.date}} selected="selected" {{/if}} value="date"  >Datum</option>
            <option {{#if type.time}} selected="selected" {{/if}} value="time"  >Zeit</option>
            <option {{#if type.rating}} selected="selected" {{/if}} value="rating"  >Rating</option>
            <option {{#if type.location}} selected="selected" {{/if}} value="location"  >Location</option>
            <option {{#if type.address}} selected="selected" {{/if}} value="address"  >Adresse</option>
          </select>
        </div>
        <div class="do-clear tiny"></div>
      </div>

      <div class="cnt-cont">{{{cnt}}}</div>

      <div>
          <button class="wgt-button wgac-sub-finished">Fertig</button>
      </div>

    </div>

  </div>

  <div class="content preview" style="width:100%;" >
        
  </div>

  <div class="do-clear">&nbsp;</div>
</section>
</script>

<script id="tpl-buiz-form-designer-text" type="text/x-handlebars-template" >
<div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
  <div class="wgt-label">
    <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">&nbsp;</label>
  </div>
  <div class="wgt-input">
    <input 
        type="text" 
        class="readonly" 
        placeholder="Antwort"
        readonly="readonly" />
  </div>
  <div class="do-clear tiny"></div>
</div>
</script>

<script id="tpl-buiz-form-designer-preview-text" type="text/x-handlebars-template" >
<div class="left n-cols-2" >
  <div class="wgt-box input">
    <div class="wgt-label">
      <label class="wgt-label">{{title}} {{#if required}}<span class="required" >*</span>{{/if}}</label>
    </div>
    <div class="wgt-input">
      <input type="text" class="readonly" placeholder="Antwort"
        readonly="readonly" />
    </div>
    {{#if helptext}}
      <div class="wgt-helptext" >
        {{helptext}}
      </div>
    {{/if}}
    <div class="do-clear tiny"></div>
  </div>
</div>
</script>

<script id="tpl-buiz-form-designer-textarea" type="text/x-handlebars-template" >
<div class="wgt-box input" >
  <div class="wgt-label">
    <label 
      class="wgt-label" >&nbsp;</label>
  </div>
  <div class="wgt-input">
    <textarea class="readonly" placeholder="Antwort"></textarea>
  </div>
  <div class="do-clear tiny"></div>
</div>
</script>

<script id="tpl-buiz-form-designer-preview-textarea" type="text/x-handlebars-template" >
<div class="wgt-box input" >
  <div class="wgt-label">
    <label 
      class="wgt-label" >{{title}}</label>
  </div>
  <div class="wgt-input">
    <textarea class="readonly" placeholder="Antwort"></textarea>
  </div>
  <div class="do-clear tiny"></div>
</div>
</script>


<script id="tpl-buiz-form-designer-checkboxes" type="text/x-handlebars-template" >
 <div class="wgt-box input" >
        <div class="wgt-label">
          <label class="wgt-label" >Field 1</label>
        </div>
        <div class="wgt-input">
          <i class="fa fa-square-o" ></i>
            <input 
              type="text"
              name="pos[{{pos}}][label][]"
              class="{{formid}}"  />
        </div>
        <div class="do-clear tiny"></div>
      </div>
 <div class="wgt-box input" >
        <div class="wgt-label">
          <label class="wgt-label" >Field 1</label>
        </div>
        <div class="wgt-input">
          <i class="fa fa-square-o" ></i>
            <input 
              type="text"
              name="pos[{{pos}}][label][]"
              class="{{formid}}"  />
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-radios" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-range" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-money" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-matrix" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-list" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-file" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-image" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-date" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-rating" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-location" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>

<script id="tpl-buiz-form-designer-address" type="text/x-handlebars-template" >
 <div class="wgt-box input" id="wgt-box-buiz-form-designer-value-pos-{{pos}}">
        <div class="wgt-label">
          <label class="wgt-label" for="wgt-inp-buiz-form-designer-value-pos-{{pos}}">Value</label>
        </div>
        <div class="wgt-input">
          <textarea 
            name="pos[{{pos}}][value]"
            class="{{formid}}" 
            id="wgt-inp-buiz-form-designer-value-pos-{{pos}}" ></textarea>
        </div>
        <div class="do-clear tiny"></div>
      </div>
</script>