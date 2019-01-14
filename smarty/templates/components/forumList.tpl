<div class='forum_list'>
    {foreach from=$forumList key=k item=v}
        <span class='category'>{$k}</span>
        {foreach from=$v key=k2 item=v2}
            <div class='forum_topic_row' fid='{$v2.id}'>
                <div class='forum_topic_item'>
                    <div class='name'>{$k2}</div>
                    <div class='item'>
                        <div class="info">
                            <span class='threads'><span class="title">Threads:</span> {$v2.threads}</span>
                            <span class='posts'><span class="title">Posts:</span> {$v2.posts}</span>
                        </div>
                        <div class='desc'>{$v2.description}</div>
                    </div>
                </div>
            </div>
        {/foreach}
    {/foreach}

</div>