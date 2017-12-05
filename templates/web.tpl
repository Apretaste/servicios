<center>
<p style="color:gray;">Escoja un servicio para comenzar</p>

{space10}

{foreach from=$services key=key item=item}
	<h2><big>{$key|upper}</big></h2>
	{foreach from=$item item=service}
		<div title="{$service->description}" class="service-block">
			{link href="{$service->name}" caption="
				{img src="{$service->image}" alt="{$service->name}" width="100%"}
				<small>{$service->name}</small>
			" style="color:black;"}
		</div>
	{/foreach}
	{space30}
{/foreach}
</center>

<style>
	.service-block {
		width: 80px;
		display: inline-block;
		margin: 10px;
	}
</style>
