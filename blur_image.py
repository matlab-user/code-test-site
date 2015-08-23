from PIL import Image
from numpy import *
from scipy.ndimage import filters
import pylab

im = array( Image.open('test.jpg').convert('L') )
im2 = filters.gaussian_filter( im, 5 )

pylab.gray()
pylab.imshow( im ) 

pylab.figure()
pylab.imshow( im2 )

pylab.show()