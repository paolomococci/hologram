#!/usr/bin/python3

import random

# generate latest three digit string of dummy MAC address
def latestThreePseudoRandomOfDummyMAC():
        latest_three_mac = [ random.randint(0x00, 0x7f), random.randint(0x00, 0xff), random.randint(0x00, 0xff) ]
        return ':'.join(map(lambda x: "%02x" % x, latest_three_mac))

print(latestThreePseudoRandomOfDummyMAC())
