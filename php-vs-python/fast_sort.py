import random
import time
import timeit
import struct
import sys

def show_arr( arr ):
    num = 0
    for i in arr:
        print i,
        num += 1
        if num==10:
            print
            num = 0

def classify( sid, eid ):
    global arr_num

    num = len( arr_num )

    if sid>=eid:
        return 0,0,0,0

    l_arr = []
    r_arr = []
    base = arr_num[eid]

    for i in arr_num[sid:eid]:
        if i<=base:
            l_arr.append( i )
        else:
            r_arr.append( i )

    l_sid = sid
    l_eid = l_sid + len(l_arr) - 1
    r_sid = l_eid + 2
    r_eid = r_sid + len(r_arr) - 1

    arr_1 = []
    if (sid-1)>=0:
        arr_1 = arr_num[0:sid]

    arr_2 = []
    if (eid+1)<=(num-1):
        arr_2 = arr_num[eid+1:]

    arr_num = arr_1 + l_arr + [base] + r_arr + arr_2

    return l_sid,l_eid,r_sid,r_eid

def f_sort( sid, eid ):
    if sid>=eid:
        return

    l_sid,l_eid,r_sid,r_eid = classify( sid, eid )
    f_sort( l_sid, l_eid )
    f_sort( r_sid, r_eid )

def find_min_max( fname ):
    min_v = 0
    max_v = 0
    data_str = ''

    fp = open( fname, 'rb' )
    while 1:
        data_str = fp.read( 1024*8 )
        slen = len( data_str )
        if slen<=0:
            break

        for i in range(0, slen, 4):
            mid = struct.unpack( "i", data_str[i:i+4] )[0]
            if mid<min_v:
                min_v = mid
                continue;

            if mid>max_v:
                max_v = mid

        data_str = ''

    fp.close()
    return min_v, max_v

def get_range( min_v, max_v, fname ):
    res = [];
    data_str = ''

    fp = open( fname, 'rb' )
    while 1:
        data_str = fp.read( 1024*8 )
        slen = len( data_str )
        if slen<=0:
            break

        for i in range(0, slen, 4):
            mid = struct.unpack( "i", data_str[i:i+4] )[0]
            if min_v <= mid < max_v:
                res += [ mid ]
                continue;

        data_str = ''

    fp.close()
    return res

#-------------------------------------------------------------------------------
fname = 'nums.dat'

print "Start sorting!"
start = timeit.default_timer()

min_v, max_v = find_min_max( fname )
rd = range(min_v,max_v,1024*10) + [ max_v ]
for i, v in enumerate( rd[0:-1] ):
    arr_num = get_range( v, rd[i+1], fname )
    f_sort( 0, len(arr_num)-1 )
    print arr_num

elapsed = (timeit.default_timer() - start)
print "Use %f s" % elapsed
