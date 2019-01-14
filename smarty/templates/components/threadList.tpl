<div class='forum_list'>


        <span class='category'>{$threadList[0]}</span>
    {foreach from=$threadList key=k item=v}
            <div class='forum_thread_row' tid='{$v.threadId}'>
                <div class='forum_topic_item'>
                    <div class='name'>{$v.threadTitle}</div>
                    <div class='item'>
                        <div class='desc'>{$v.author}</div>
                        <div class="info">
                            <span class='threads'><span class="title">Posts:</span> {$v.posts}</span>
                            <span class='threads'><span class="title">Last Post:</span> {$v.lastPost}</span>
                            <span class='posts'><span class="title">By:</span> {$v.lastPostBy}</span>
                        </div>
                    </div>
                </div>
            </div>
    {/foreach}

</div>