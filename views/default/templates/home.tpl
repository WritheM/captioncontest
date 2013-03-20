{if $contest.current->id !== 0}
  Current Week:
  <PRE>
    {$contest.current|print_r}
  </PRE>
{else}
  Doesn't look like we currently have any contests running<br />
{/if}
{if $contest.previous->id !== 0}
  Previous Week:
  <PRE>
    {$contest.previous|print_r}
  </PRE>
{/if}