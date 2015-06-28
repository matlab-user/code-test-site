/*
	dev		.g1
			.name			用户自定义名称
			.model			设备型号名称
			.state
			.tz
			.maker		(设备生产厂商，未实现)
			.lo				经度 （以后实时更新）
			.la				纬度 （以后实时更新）
			.data[]			Object 数组
			
	data[j] .d_id			参数id
			.lt				UTC时间，最后更新参数
			.plot			flot handler/ or UI handle
			.d_name			参数名称
			.remark	
			.ss				ss==0 累积数据; ss==1 不累积数据;
			.unit			单位
			.new_v			最新数据值
			.new_t			更新时间
			.real_h			图像实际 height
			.real_w			图像实际 width
			.update_fun		此参数的更新函数
			.json			数组, state 使用
			
	op[j] .id
		  .name
		  .remark
		  .p_num
		  .P[0]....
	
		P[j] .id
			 .name
			 .remark
			 .unit
*/

var dev = new Object();

dev.name = '我的设备1';
dev.model = 'swaytech-1';
dev.g1 = '00001';
dev.tz = 8;
dev.lt = 0;
dev.maker = 'swaytech';
dev.lo = '104.06<sup>。</sup>';
dev.la = '30.67<sup>。</sup>';

dev.data = new Array();

var mid = new Object();
mid.name = 'state-1';
mid.d_id = 1;
mid.new_t = new Date().getTime()/1000;
mid.new_v = 21;
mid.unit = 'state';
mid.remark = '[ { "0":"0bit_name","v":["x0","y0"] },\
				{ "1":"1bit_name","v":["x1","y1"] }, \
				{ "5":"5bit_name","v":["x5","y5"] } ]';

dev.data[0] = mid;

function add_state_view( d_i ) {
	
	var target = dev.data[d_i];
	
	var main = $('#flot_zone');
	var div_id = d_i+'_state_holder';		// 需要修改
	
	var li = $('<li class="module"><p class="title">'+target.name+'<span type="time"></span></p></li>');
	target.plot = li;
	main.append( li );
	li.find('span[type="time"]').html( '2014.12.10 22:44:10' );
	li.append('<div class="flot_holder"><table class="state_show_table" id="'+div_id+'"><tbody></tbody></table></div>');

	parse_state_remark( d_i );
	
	var tbody = $('#'+div_id ).children('tbody');	
	for( $i=0; $i<8; $i++ )
		tbody.append( $('<tr><td id="'+$i+'_bit"></td><td id="'+$i+'_bit_v"></td><td id="'+($i+8)+'_bit"></td><td id="'+($i+8)+'_bit_v"></td></tr>') );
	
	for( x in target.json ) {
		var t = target.json[x];
		for( y in t ) {
			switch(y) {
				case 'v':
				case 'mask':
					break;
				default:
					var td_id = '#' + y + '_bit';
					$(td_id ).html( target.json[x][y] );
					break;
			}
		}
	}
		
	target.update_fun = state_update_fun;
}

// dev.data[d_i].json - 对象数组
// 每个 json 对象中有：mask 域；bit 域，数值，位序号；
function parse_state_remark( d_i ) {
	
	var unit = dev.data[d_i].unit;
	var remark = dev.data[d_i].remark;
	
	if( unit!='state' || remark.length<=0 )
		return false;
	
	dev.data[d_i].json = JSON.parse( remark );
	
	// 计算 mask
	for ( x in dev.data[d_i].json ) {
		
		var t = dev.data[d_i].json[x];
		
		for( y in t ) {
			switch( y ) {
				case 'v':
				case 'mask':
					break;
				default:
					var num = Math.abs( parseInt(y) );
					if( num<=15  ) {
						t.mask = 1 << num;
						t.bit = num;
					}
					break;
			}
		}
	}
	
}

function state_update_fun() {
	var li = this.plot;
	
	var t = new Date();
	t.setTime( (this.new_t+dev.tz*3600)*1000 );
	var t_str = t.getUTCFullYear()+'.'+(t.getUTCMonth()+1)+'.'+t.getUTCDate()+" "+t.getUTCHours()+':'+t.getUTCMinutes()+':'+t.getSeconds();
	li.find('span[type="time"]').html( t_str );
	
	this.lt = this.new_t;
	
	for( x in this.json ) {
		var num = this.json[x].bit;
		var mask = this.json[x].mask; 
		var res = (this.new_v & mask) >> num;
		
		var td_id = '#' + num + '_bit_v';
		
		$( td_id ).html( this.json[x].v[res] );
	}
}

