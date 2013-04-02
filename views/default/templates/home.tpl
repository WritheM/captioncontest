{if $contest.current->id !== 0}
  Current Week:
  <div class="well">
    <img src="{$contest.current->image->path}" class="img-polaroid" height="{$contest.current->image->height}" width="{$contest.current->image->width}" /><br />
    End:{$contest.current->end|date_format} <br />
    Sign in to Submit your caption now!<br />
  </div>
{else}
  Doesn't look like we currently have any contests running<br />
{/if}
{if $contest.previous->id !== 0}
  Previous Week:
  <div class="well">
    
    <div class="carousel-inner">
      <img src="{$contest.previous->image->path}" class="img-polaroid" height="{$contest.previous->image->height}" width="{$contest.previous->image->width}" />
      {$contest.previous->start|date_format} - {$contest.previous->end|date_format} 
    <a class="carousel-control left clearfix" style="top:{$contest.previous->image->height -50}px;left:15px" href="#lastWeeksCaptions" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right clearfix" style="top:{$contest.previous->image->height -50}px;left:{$contest.previous->image->width -50}px" href="#lastWeeksCaptions" data-slide="next">&rsaquo;</a>
    </div>
    <div id="lastWeeksCaptions" class="carousel slide" data-pause="hover" data-interval="5000">
      <!-- Carousel items -->
      <div class="carousel-inner">
      {foreach $contest.previous->captions as $caption}
        {if $caption->status->id == 2}
        <div class="item{if false} active{/if}">
            <pre>{$caption->caption}</pre>
            - {$caption->sub_disp}
        </div>
        {/if}
      {/foreach}
      </div>
    </div>
  </div>
{/if}