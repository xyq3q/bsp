# Author: EDB
# Created On: 11st August 2017
# E-mail: edb@paituo.me
import os,sys
import json
import codecs
import math
import time
import urllib
import hashlib

def get_traffic(port):
 result = os.popen("iptables -n -v -L -t filter -x |grep -i 'spt:" + port + "'|awk '{print $2}'")
 res = result.read()
 if res=="":
  return ""
 else:
  return int(round(float(res)/math.pow(1000,2)))

def md5(src):
 return hashlib.md5(src).hexdigest()

def get_traffic_web(port):
 params={'port':port,'key':md5(str(r_config()['bsp_key'])+str(port))}
 res=http_get(r_config()['get_traffic_url'],params)
 return int(res)

def mod_traffic_web(port,t):
 params = {'port': port, 'key': md5(str(r_config()['bsp_key']) + str(port) + str(t)),'t':t}
 res = http_get(r_config()['mod_traffic_url'], params)
 return res

def http_get(url,params):
 params=urllib.urlencode(params)
 f = urllib.urlopen(url + "?%s" % params)
 res = f.read()
 return res

def add_rules(port):
 res = get_traffic(port)
 if res!="":
  del_rules(port)
  os.system('iptables -A OUTPUT -p tcp --sport ' + port)
  os.system('iptables -A INPUT -p tcp --dport ' + port)
 else:
  os.system('iptables -A OUTPUT -p tcp --sport ' + port)
  os.system('iptables -A INPUT -p tcp --dport ' + port)

def del_rules(port):
 os.system('iptables -D OUTPUT -p tcp --sport ' + port)
 os.system('iptables -D INPUT -p tcp --dport ' + port)

def r_config():
 with codecs.open('/etc/byte/byte_ss.json') as json_file:
  data = json.load(json_file)
  return data

def w_cofig(data):
 with codecs.open('/etc/byte/byte_ss.json', 'w', 'utf-8') as json_file:
  json_file.write(json.dumps(data, sort_keys=True, indent=4).decode('utf-8'))

def r_json():
 with codecs.open(r_config()['ssconf_path']) as json_file:
  data = json.load(json_file)
  return data

def w_json(data):
 with codecs.open(r_config()['ssconf_path'], 'w', 'utf-8') as json_file:
  json_file.write(json.dumps(data, sort_keys=True, indent=4).decode('utf-8'))

def a_limit(port,size):
 data = r_config()
 data['port_limit'][port] = size
 w_cofig(data)

def c_limit(port):
 data = r_config()
 return data['port_limit'][port]

def d_limit(port):
 data = r_config()
 del data['port_limit'][port]
 w_cofig(data)

def a_json(port,pwd):
   data=r_json()
   data['port_password'][port] = pwd
   w_json(data)

def add_rules_from_limit():
  data = r_config()
  data = data['port_limit']
  p = list(data)
  if len(p)!=0:
    for i,port in enumerate(p):
      add_rules(port)
  else:
    print "there is no limit"

def d_json(port):
 data=r_json()
 del data['port_password'][port]
 w_json(data)

def restart_ss():
 sys.stdout.flush()
 sys.stderr.flush()
 si = file("/dev/null", 'r')
 so = file("/dev/null", 'a+')
 se = file("/dev/null", 'a+', 0)
 os.dup2(si.fileno(), sys.stdin.fileno())
 os.dup2(so.fileno(), sys.stdout.fileno())
 os.dup2(se.fileno(), sys.stderr.fileno())
 os.popen(r_config()['ress_cmd'])

def c_json(port):
 data=r_json()
 return data['port_password'][port]

def start():
 while 1:
  data = r_config()
  data = data['port_limit']
  p = list(data)
  if len(p)==0:
   with open('bsp_pid','w+') as f:
    f.write("")
   f.close() 
   sys.exit('without any limit bsp stoped')
  else:
   if r_config()['limit_method']=='local':
     for i, port in enumerate(p):
      # print i,port,data[port],get_traffic(port)
      if int(get_traffic(port)) >= int(data[port]):
       d_json(port)
       d_limit(port)
       del_rules(port)
     restart_ss()
   elif r_config()['limit_method']=='web':
     for i, port in enumerate(p):
     # print i,port,data[port],get_traffic(port)
      if int(get_traffic(port))>0:
       traffic = get_traffic_web(port)+int(get_traffic(port))
       mod_traffic_web(port, get_traffic(port))
       if int(traffic) >= int(data[port]):
        d_json(port)
        d_limit(port)
        del_rules(port)
     add_rules_from_limit()
     restart_ss()
  time.sleep(float(r_config()['update_time']))



