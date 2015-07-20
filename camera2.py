
import cv2

camera = cv2.VideoCapture( 0 )

success, frame = camera.read()

	
if success :

	print 'camera read %s' % success
	cv2.namedWindow( "demo1" )
	cv2.imshow( "demo1", frame )
	cv2.waitKey( 0 ) 
	cv2.destroyWindow( "demo1" )
