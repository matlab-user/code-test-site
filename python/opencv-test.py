import cv2
import numpy as np
import sys 

if __name__ == '__main__':
	winName = 'display image'
	imagePath = 'default.jpg'
	cv2.namedWindow( winName )
	image=cv2.imread( imagePath )
		
	if np.any(image):	
		cv2.imshow( winName, image )
		cv2.waitKey( 0 ) 
		cv2.destroyWindow( winName )
	else:
		print "no image found!"
