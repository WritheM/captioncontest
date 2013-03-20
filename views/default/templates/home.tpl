{if $contest.current->id !== 0}
  Current Week:
  <PRE>
    <img src="{$contest.current->image->path}" height="{$contest.current->image->height}" width="{$contest.current->image->width}" />
    End:{$contest.current->end|date_format} 
    Sign in to Submit your caption now!
  </PRE>
{else}
  Doesn't look like we currently have any contests running<br />
{/if}
{if $contest.previous->id !== 0}
  Previous Week:
  <PRE>
         
    <img src="{$contest.previous->image->path}" height="{$contest.previous->image->height}" width="{$contest.previous->image->width}" />
    {$contest.previous->start|date_format} - {$contest.previous->end|date_format} 

    {$contest.previous->captions|print_r}
  </PRE>
{/if}